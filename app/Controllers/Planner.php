<?php

namespace App\Controllers;

use App\Models\PlannerModel;
use App\Models\ImportantReminderModel;

class Planner extends BaseController
{
    /**
     * Haftalık programı gösterir.
     */
    public function index()
{
    $studentId = session()->get('user_id');

    if (!$studentId) {
        return redirect()->to('/login');
    }

    $plannerModel = new PlannerModel();
    $reminderModel = new ImportantReminderModel();

    // BU HAFTA
    $today = new \DateTime();
    $dayOfWeek = (int) $today->format('N');

    $monday = clone $today;
    $monday->modify('-' . ($dayOfWeek - 1) . ' days');

    $sunday = clone $monday;
    $sunday->modify('+6 days');

    // Bu haftadaki görevler
    $events = $plannerModel
        ->where('student_id', $studentId)
        ->where('event_date >=', $monday->format('Y-m-d'))
        ->where('event_date <=', $sunday->format('Y-m-d'))
        ->orderBy('event_date', 'ASC')
        ->orderBy('start_time', 'ASC')
        ->findAll();

    // BU HAFTADAN SONRAKİ GÖREVLER
    $upcomingEvents = $plannerModel
        ->where('student_id', $studentId)
        ->where('event_date >', $sunday->format('Y-m-d'))
        ->orderBy('event_date', 'ASC')
        ->orderBy('start_time', 'ASC')
        ->findAll();

    // ÖNEMLİ NOTLAR
    $reminders = $reminderModel
        ->where('student_id', $studentId)
        ->orderBy('is_completed', 'ASC')
        ->orderBy('created_at', 'DESC')
        ->findAll();

    // TAKVİMDE GÖSTERİLECEK AY
    $calendarMonth = (int) $this->request->getGet('month');
    $calendarYear = (int) $this->request->getGet('year');

    // Geçerli ay/yıl verilmemişse mevcut ayı kullan
    if (
        $calendarMonth < 1 ||
        $calendarMonth > 12 ||
        $calendarYear < 2000 ||
        $calendarYear > 2100
    ) {
        $calendarMonth = (int) $today->format('m');
        $calendarYear = (int) $today->format('Y');
    }

    return view('student/planner', [
        'events' => $events,
        'upcomingEvents' => $upcomingEvents,
        'reminders' => $reminders,

        'weekStart' => $monday->format('Y-m-d'),
        'weekEnd' => $sunday->format('Y-m-d'),

        'calendarMonth' => $calendarMonth,
        'calendarYear' => $calendarYear
    ]);
}
    /**
     * Yeni haftalık görev ekler.
     */
    public function addEvent()
    {
        $studentId = session()->get('user_id');

        if (!$studentId) {
            return redirect()->to('/login');
        }

        $title = trim(
            $this->request->getPost('title')
        );

        $description = trim(
            $this->request->getPost('description')
        );

        $eventDate =
            $this->request->getPost('event_date');

        $startTime =
            $this->request->getPost('start_time');

        $endTime =
            $this->request->getPost('end_time');

        $reminderAt =
            $this->request->getPost('reminder_at');


        // Görev adı zorunlu
        if ($title === '') {
            return redirect()
                ->back()
                ->with(
                    'error',
                    'Görev adı boş bırakılamaz.'
                );
        }


        $plannerModel = new PlannerModel();

        $saved = $plannerModel->insert([
            'student_id' => $studentId,
            'title' => $title,
            'description' => $description ?: null,
            'event_date' => $eventDate,
            'start_time' => $startTime ?: null,
            'end_time' => $endTime ?: null,
            'reminder_at' => $reminderAt ?: null,
            'is_completed' => false
        ]);


        if (!$saved) {
            return redirect()
                ->back()
                ->with(
                    'error',
                    'Görev eklenemedi.'
                );
        }


        return redirect()
            ->to('/student/planner')
            ->with(
                'success',
                'Görev başarıyla eklendi.'
            );
    }


    /**
     * Görevi tamamlandı / tamamlanmadı yapar.
     */
    public function toggleEvent($id)
    {
        $studentId = session()->get('user_id');

        if (!$studentId) {
            return redirect()->to('/login');
        }

        $plannerModel = new PlannerModel();

        $event = $plannerModel
            ->where('id', $id)
            ->where('student_id', $studentId)
            ->first();

        if (!$event) {
            return redirect()
                ->back()
                ->with(
                    'error',
                    'Görev bulunamadı.'
                );
        }

        $plannerModel->update(
            $id,
            [
                'is_completed' =>
                    !$event['is_completed']
            ]
        );

        return redirect()->back();
    }


    /**
     * Görevi siler.
     */
    public function deleteEvent($id)
    {
        $studentId = session()->get('user_id');

        if (!$studentId) {
            return redirect()->to('/login');
        }

        $plannerModel = new PlannerModel();

        $event = $plannerModel
            ->where('id', $id)
            ->where('student_id', $studentId)
            ->first();

        if (!$event) {
            return redirect()
                ->back()
                ->with(
                    'error',
                    'Görev bulunamadı.'
                );
        }

        $plannerModel->delete($id);

        return redirect()->back();
    }
    
    public function showAddReminder()
{
    $studentId = session()->get('user_id');

    if (!$studentId) {
        return redirect()->to('/login');
    }

    return view('student/planner_add_reminder');
}


    /**
     * Don't Forget listesine yeni madde ekler.
     */
    public function addReminder()
    {
        $studentId = session()->get('user_id');

        if (!$studentId) {
            return redirect()->to('/login');
        }

        $title = trim(
            $this->request->getPost('title')
        );

        if ($title === '') {
            return redirect()
                ->back()
                ->with(
                    'error',
                    'Önemli not boş bırakılamaz.'
                );
        }

        $reminderModel =
            new ImportantReminderModel();

        $saved = $reminderModel->insert([
            'student_id' => $studentId,
            'title' => $title,
            'is_completed' => false
        ]);

        if (!$saved) {
            return redirect()
                ->back()
                ->with(
                    'error',
                    'Önemli not eklenemedi.'
                );
        }

        return redirect()
            ->to('/student/planner')
            ->with(
                'success',
                'Önemli not eklendi.'
            );
    }


    /**
     * Don't Forget maddesini
     * tamamlandı / tamamlanmadı yapar.
     */
    public function toggleReminder($id)
    {
        $studentId = session()->get('user_id');

        if (!$studentId) {
            return redirect()->to('/login');
        }

        $reminderModel =
            new ImportantReminderModel();

        $reminder = $reminderModel
            ->where('id', $id)
            ->where('student_id', $studentId)
            ->first();

        if (!$reminder) {
            return redirect()
                ->back()
                ->with(
                    'error',
                    'Not bulunamadı.'
                );
        }

        $reminderModel->update(
            $id,
            [
                'is_completed' =>
                    !$reminder['is_completed']
            ]
        );

        return redirect()->back();
    }


    /**
     * Don't Forget maddesini siler.
     */
    public function deleteReminder($id)
    {
        $studentId = session()->get('user_id');

        if (!$studentId) {
            return redirect()->to('/login');
        }

        $reminderModel =
            new ImportantReminderModel();

        $reminder = $reminderModel
            ->where('id', $id)
            ->where('student_id', $studentId)
            ->first();

        if (!$reminder) {
            return redirect()
                ->back()
                ->with(
                    'error',
                    'Not bulunamadı.'
                );
        }

        $reminderModel->delete($id);

        return redirect()->back();
    }
    public function showAddEvent()
{
    $studentId = session()->get('user_id');

    if (!$studentId) {
        return redirect()->to('/login');
    }

    $selectedDate = $this->request->getGet('date');

    if (!$selectedDate) {
        $selectedDate = date('Y-m-d');
    }

    return view('student/planner_add', [
        'selectedDate' => $selectedDate
    ]);
}
}