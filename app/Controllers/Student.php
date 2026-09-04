<?php

namespace App\Controllers;

class Student extends BaseController
{
    public function dashboard()
{
    $studentId = session()->get('user_id');

    if (!$studentId) {
        return redirect()->to('/login');
    }

    $db = \Config\Database::connect();

    /*
    |--------------------------------------------------------------------------
    | Öğrenci bilgileri
    |--------------------------------------------------------------------------
    */

    $user = $db->table('users')
        ->select('username')
        ->where('id', $studentId)
        ->get()
        ->getRowArray();


    /*
    |--------------------------------------------------------------------------
    | Kitaplık bilgileri
    |--------------------------------------------------------------------------
    */

    $totalBooks = $db->table('student_books')
        ->where('student_id', $studentId)
        ->countAllResults();


    $readingBooks = $db->table('student_books')
        ->where('student_id', $studentId)
        ->where('status', 'reading')
        ->countAllResults();


    $completedBooks = $db->table('student_books')
        ->where('student_id', $studentId)
        ->where('status', 'completed')
        ->countAllResults();


    /*
    |--------------------------------------------------------------------------
    | Bugünün programı
    |--------------------------------------------------------------------------
    */

    $today = date('Y-m-d');


    $todayEvents = $db->table('planner_events')
        ->where('student_id', $studentId)
        ->where('event_date', $today)
        ->orderBy('start_time', 'ASC')
        ->get()
        ->getResultArray();


    /*
    |--------------------------------------------------------------------------
    | Bugünün tamamlanmamış görevleri
    |--------------------------------------------------------------------------
    */

    $todayPendingEvents = $db->table('planner_events')
        ->where('student_id', $studentId)
        ->where('event_date', $today)
        ->where('is_completed', 0)
        ->countAllResults();


    /*
    |--------------------------------------------------------------------------
    | Önemli hatırlatıcılar
    |--------------------------------------------------------------------------
    */

    $pendingReminders = $db->table('important_reminders')
        ->where('student_id', $studentId)
        ->where('is_completed', 0)
        ->orderBy('created_at', 'DESC')
        ->get()
        ->getResultArray();


    /*
    |--------------------------------------------------------------------------
    | Dashboard'a gönderilecek veriler
    |--------------------------------------------------------------------------
    */

    return view('student/dashboard', [

        'username' => $user['username'] ?? 'Öğrenci',

        'totalBooks' => $totalBooks,

        'readingBooks' => $readingBooks,

        'completedBooks' => $completedBooks,

        'todayEvents' => $todayEvents,

        'todayPendingEvents' => $todayPendingEvents,

        'pendingReminders' => $pendingReminders

    ]);
}

    public function library()
    {
        return view('student/library');
    }

    public function planner()
    {
        return view('student/planner');
    }

    public function chatbot()
{
    $studentId = session()->get('user_id');

    if (!$studentId) {
        return redirect()->to('/login');
    }

    $chatModel = new \App\Models\ChatModel();

    $messages = $chatModel
        ->where('student_id', $studentId)
        ->orderBy('created_at', 'ASC')
        ->findAll();

    return view('student/chatbot', [
        'messages' => $messages
    ]);
}
 public function profile()
{
    $userId = session()->get('user_id');

    if (!$userId) {
        return redirect()->to('/login');
    }

    $userModel = new \App\Models\UserModel();

    $user = $userModel->find($userId);

    if (!$user) {
        return redirect()->to('/login');
    }

    return view('student/profile', [
        'user' => $user
    ]);
}
public function updateEmail()
{
    $userId = session()->get('user_id');

    if (!$userId) {
        return redirect()->to('/login');
    }

    $newEmail = trim($this->request->getPost('new_email'));
    $currentPassword = $this->request->getPost('current_password');

    // Yeni e-posta kontrolü
    if (!filter_var($newEmail, FILTER_VALIDATE_EMAIL)) {
        return redirect()->back()->with(
            'error',
            'Geçerli bir e-posta adresi giriniz.'
        );
    }

    // Mevcut kullanıcıyı getir
    $userModel = new \App\Models\UserModel();
    $user = $userModel->find($userId);

    if (!$user) {
        return redirect()->to('/login');
    }

    // Eski şifre kontrolü
    if (!password_verify($currentPassword, $user['password'])) {
        return redirect()->back()->with(
            'error',
            'Mevcut şifreniz hatalı.'
        );
    }

    // E-posta başka kullanıcıda kullanılıyor mu?
    $existingUser = $userModel
        ->where('email', $newEmail)
        ->where('id !=', $userId)
        ->first();

    if ($existingUser) {
        return redirect()->back()->with(
            'error',
            'Bu e-posta adresi başka bir kullanıcı tarafından kullanılıyor.'
        );
    }

    // E-postayı güncelle
    $updated = $userModel->update($userId, [
        'email' => $newEmail
    ]);

    if (!$updated) {
        return redirect()->back()->with(
            'error',
            'E-posta güncellenemedi.'
        );
    }

    return redirect()->to('/student/profile')->with(
        'success',
        'E-posta adresiniz başarıyla değiştirildi.'
    );
}
public function updatePassword()
{
    $userId = session()->get('user_id');

    if (!$userId) {
        return redirect()->to('/login');
    }

    $currentPassword = $this->request->getPost('current_password');
    $newPassword = $this->request->getPost('new_password');
    $newPasswordAgain = $this->request->getPost('new_password_again');

    $userModel = new \App\Models\UserModel();

    $user = $userModel->find($userId);

    if (!$user) {
        return redirect()->to('/login');
    }

    // Mevcut şifre doğru mu?
    if (!password_verify($currentPassword, $user['password'])) {
        return redirect()->back()->with(
            'error',
            'Mevcut şifreniz hatalı.'
        );
    }

    // Yeni şifreler aynı mı?
    if ($newPassword !== $newPasswordAgain) {
        return redirect()->back()->with(
            'error',
            'Yeni şifreler birbiriyle uyuşmuyor.'
        );
    }

    // Şifre uzunluğu
    if (strlen($newPassword) < 6) {
        return redirect()->back()->with(
            'error',
            'Yeni şifre en az 6 karakter olmalıdır.'
        );
    }

    // Eski şifreyle aynı mı?
    if (password_verify($newPassword, $user['password'])) {
        return redirect()->back()->with(
            'error',
            'Yeni şifreniz mevcut şifrenizden farklı olmalıdır.'
        );
    }

    // Yeni şifreyi güvenli şekilde hashle
    $hashedPassword = password_hash(
        $newPassword,
        PASSWORD_DEFAULT
    );

    $updated = $userModel->update($userId, [
        'password' => $hashedPassword
    ]);

    if (!$updated) {
        return redirect()->back()->with(
            'error',
            'Şifre güncellenemedi.'
        );
    }

    return redirect()->to('/student/profile')->with(
        'success',
        'Şifreniz başarıyla değiştirildi.'
    );
}
public function sendChatMessage()
{
    $message = trim($this->request->getPost('message'));

    if ($message === '') {
        return $this->response->setJSON([
            'success' => false,
            'message' => 'Mesaj boş olamaz.'
        ]);
    }

    $studentId = session()->get('user_id');

    if (!$studentId) {
        return $this->response->setJSON([
            'success' => false,
            'message' => 'Oturum bulunamadı.'
        ]);
    }

    $chatModel = new \App\Models\ChatModel();

    /*
     * 1. ÖĞRENCİNİN MESAJINI DB'YE KAYDET
     */

    $saved = $chatModel->insert([
        'student_id' => $studentId,
        'role' => 'user',
        'message' => $message
    ]);

    if (!$saved) {
        return $this->response->setJSON([
            'success' => false,
            'message' => 'Mesaj kaydedilemedi.'
        ]);
    }


    /*
     * 2. ÖNCEKİ KONUŞMALARI DB'DEN AL
     */

    $messages = $chatModel
        ->where('student_id', $studentId)
        ->orderBy('created_at', 'ASC')
        ->findAll();


    /*
     * 3. GEMINI'YE GÖNDERECEĞİMİZ GEÇMİŞİ HAZIRLA
     */

    $contents = [];

    foreach ($messages as $chatMessage) {

        $contents[] = [
            'role' => $chatMessage['role'] === 'assistant'
                ? 'model'
                : 'user',

            'parts' => [
                [
                    'text' => $chatMessage['message']
                ]
            ]
        ];
    }


    /*
     * 4. GEMINI API ANAHTARINI AL
     */

    $apiKey = getenv('GEMINI_API_KEY');

    if (!$apiKey) {
        return $this->response->setJSON([
            'success' => false,
            'message' => 'Gemini API anahtarı bulunamadı.'
        ]);
    }


    /*
     * 5. GEMINI API ADRESİ
     */

    $url =
        'https://generativelanguage.googleapis.com/v1beta/models/gemini-3.6-flash:generateContent';


    /*
     * 6. GEMINI'YE İSTEK GÖNDER
     */

    $payload = json_encode([
    'systemInstruction' => [
        'parts' => [
            [
                'text' => '
Sen "Öğrenci Asistanı" adlı bir yapay zekâ asistanısın. Öğrenci Platformunun bir parçasısın.

Öğrencilere ders çalışma, sınav hazırlığı, ödevler, zaman yönetimi, okul hayatı ve motivasyon konularında yardımcı ol.

CEVAP TARZI:
- Her zaman Türkçe konuş.
- Samimi, doğal ve destekleyici ol.
- Cevaplarını kısa ve kolay okunabilir tut.
- Normal sorulara genellikle 3-6 cümleden fazla cevap verme.
- Gerektiğinde en fazla 3-5 maddelik kısa listeler kullan.
- Gereksiz açıklama, tekrar ve uzun girişler yapma.
- Öğrencinin sorusuna önce doğrudan cevap ver.
- Öğrenci özellikle detaylı anlatmanı istemedikçe uzun cevap verme.
- Öğrenciyi bilgiyle boğma.
- Basit bir soru için basit bir cevap ver.

ÖĞRENCİYLE ETKİLEŞİM:
- Öğrenci ne yapacağını bilmiyorsa ilk küçük adımı söyle.
- Öğrenci ödev soruyorsa doğrudan uygulanabilir bir başlangıç öner.
- Öğrenci çalışma programı isterse kısa ve düzenli bir program oluştur.
- Öğrenci motivasyonsuzsa yargılayıcı olma; küçük ve yapılabilir bir adım öner.
- Gerektiğinde öğrenciden sadece gerçekten gerekli olan bir bilgiyi sor.
- Bir soruyu cevaplamak için gereksiz kişisel bilgi isteme.

SINIRLAR:
- Bilmediğin bir bilgiyi kesinmiş gibi söyleme.
- Öğrencinin kişisel verilerini isteme veya paylaşmasını teşvik etme.
- Öğrencinin kitaplığına, haftalık programına veya diğer platform verilerine doğrudan erişimin yoksa erişimin varmış gibi davranma.
- Kendini genel amaçlı bir chatbot gibi değil, öğrencinin okul hayatındaki yardımcısı olarak konumlandır.

FORMAT:
- Kısa paragraflar kullan.
- Kısa cümleler kullan.
- Gerektiğinde numaralı veya madde işaretli liste kullan.
- Cevabın sonunda öğrencinin devam edebilmesini sağlayacak kısa bir soru sorabilirsin.
'
            ]
        ]
    ],
    'contents' => $contents
]);


    $ch = curl_init($url);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    curl_setopt($ch, CURLOPT_POST, true);

    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'x-goog-api-key: ' . $apiKey
    ]);

    curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);


    $response = curl_exec($ch);

    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    $curlError = curl_error($ch);

    curl_close($ch);


    /*
     * 7. CURL HATASI
     */

    if ($response === false) {

        return $this->response->setJSON([
            'success' => false,
            'message' => 'Gemini bağlantı hatası: ' . $curlError
        ]);
    }


    /*
     * 8. GEMINI CEVABINI JSON OLARAK OKU
     */

    $data = json_decode($response, true);


    /*
 * 9. GEMINI API HATASI
 */

if ($httpCode === 429) {

    return $this->response->setJSON([
        'success' => false,
        'message' => '🤖 Şu anda ücretsiz kullanım limitine ulaşıldı. Lütfen daha sonra tekrar deneyin.'
    ]);
}

if ($httpCode >= 400 || isset($data['error'])) {

    $errorMessage = $data['error']['message']
        ?? 'Gemini API isteği başarısız oldu.';

    return $this->response->setJSON([
        'success' => false,
        'message' => $errorMessage
    ]);
}


    /*
     * 10. GEMINI'NİN CEVABINI AL
     */

    $reply =
        $data['candidates'][0]['content']['parts'][0]['text']
        ?? null;


    if (!$reply) {

        return $this->response->setJSON([
            'success' => false,
            'message' => 'Gemini boş bir cevap döndürdü.'
        ]);
    }


    /*
     * 11. GEMINI CEVABINI DB'YE KAYDET
     */

    $chatModel->insert([
        'student_id' => $studentId,
        'role' => 'assistant',
        'message' => $reply
    ]);


    /*
     * 12. CEVABI JAVASCRIPT'E GÖNDER
     */

    return $this->response->setJSON([
        'success' => true,
        'reply' => $reply
    ]);
}
}