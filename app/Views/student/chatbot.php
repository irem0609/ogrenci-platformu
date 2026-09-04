<!DOCTYPE html>
<html lang="tr">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Öğrenci Asistanı</title>

    <link rel="stylesheet" href="<?= base_url('student.css') ?>">

</head>


<body>


<?= view('layouts/student_sidebar') ?>


<main class="main-content">


    <div class="chatbot-page">


        <!-- CHATBOT BAŞLIK -->

        <div class="chatbot-header">

            <div class="chatbot-avatar">
                🤖
            </div>

            <div>

                <h1>Öğrenci Asistanı</h1>

                <p>
                    Ders ve okul hayatındaki yardımcın
                </p>

            </div>

        </div>



        <!-- MESAJ ALANI -->

        <div class="chatbot-messages" id="chatMessages">


            <?php foreach ($messages as $chatMessage): ?>


                <?php if ($chatMessage['role'] === 'user'): ?>


                    <!-- ÖĞRENCİ MESAJI -->

                    <div class="chat-message user-message">


                        <div class="message-avatar">
                            👤
                        </div>


                        <div class="message-content">


                            <strong>
                                <?= esc(session()->get('username') ?? 'Öğrenci') ?>
                            </strong>


                            <p>
                                <?= esc($chatMessage['message']) ?>
                            </p>


                        </div>


                    </div>


                <?php elseif ($chatMessage['role'] === 'assistant'): ?>


                    <!-- CHATBOT MESAJI -->

                    <div class="chat-message bot-message">


                        <div class="message-avatar">
                            🤖
                        </div>


                        <div class="message-content">


                            <strong>
                                Öğrenci Asistanı
                            </strong>


                            <p>
                                <?= esc($chatMessage['message']) ?>
                            </p>


                        </div>


                    </div>


                <?php endif; ?>


            <?php endforeach; ?>


        </div>



        <!-- MESAJ GÖNDERME ALANI -->

        <div class="chatbot-input-area">


            <input
                type="text"
                id="chatInput"
                placeholder="Mesajını yaz..."
                autocomplete="off"
            >


            <button
                type="button"
                id="sendMessage"
            >
                ➤
            </button>


        </div>


    </div>


</main>



<script>


const chatInput = document.getElementById('chatInput');

const sendMessage = document.getElementById('sendMessage');

const chatMessages = document.getElementById('chatMessages');



/* ================================= */
/* MESAJ GÖNDER */
/* ================================= */


sendMessage.addEventListener('click', function () {


    const message = chatInput.value.trim();


    if (message === '') {

        return;

    }



    /* =============================== */
    /* ÖĞRENCİ MESAJINI EKRANA EKLE */
    /* =============================== */


    const userMessage = document.createElement('div');

    userMessage.className = 'chat-message user-message';


    userMessage.innerHTML = `

        <div class="message-avatar">
            👤
        </div>

        <div class="message-content">

            <strong>
                <?= esc(session()->get('username') ?? 'Öğrenci') ?>
            </strong>

            <p></p>

        </div>

    `;


    userMessage.querySelector('p').textContent = message;


    chatMessages.appendChild(userMessage);



    /* INPUT TEMİZLE */

    chatInput.value = '';



    /* =============================== */
    /* PHP BACKEND'E GÖNDER */
    /* =============================== */


    fetch('<?= base_url('/student/chatbot/send') ?>', {

        method: 'POST',

        headers: {

            'Content-Type':
                'application/x-www-form-urlencoded'

        },

        body:
            'message=' +
            encodeURIComponent(message)

    })


    .then(response => response.json())


    .then(data => {


        /* =============================== */
        /* CHATBOT MESAJ KUTUSU OLUŞTUR */
        /* =============================== */


        const botMessage = document.createElement('div');

        botMessage.className = 'chat-message bot-message';


        botMessage.innerHTML = `

            <div class="message-avatar">
                🤖
            </div>

            <div class="message-content">

                <strong>
                    Öğrenci Asistanı
                </strong>

                <p></p>

            </div>

        `;


        /* =============================== */
        /* BAŞARILI CEVAP */
        /* =============================== */


        if (data.success) {


            botMessage.querySelector('p').textContent =
                data.reply;


        }


        /* =============================== */
        /* HATA / LİMİT MESAJI */
        /* =============================== */


        else {


            botMessage.querySelector('p').textContent =
                data.message || 'Bir hata oluştu.';


        }


        /* =============================== */
        /* MESAJI EKRANA EKLE */
        /* =============================== */


        chatMessages.appendChild(botMessage);


        /* EN ALTTAKİ MESAJI GÖSTER */

        chatMessages.scrollTop =
            chatMessages.scrollHeight;


    })


    .catch(error => {


        console.error('Hata:', error);


        /* =============================== */
        /* BAĞLANTI HATASI */
        /* =============================== */


        const errorMessage = document.createElement('div');

        errorMessage.className =
            'chat-message bot-message';


        errorMessage.innerHTML = `

            <div class="message-avatar">
                🤖
            </div>

            <div class="message-content">

                <strong>
                    Öğrenci Asistanı
                </strong>

                <p>
                    🤖 Asistanla bağlantı kurulurken bir hata oluştu.
                </p>

            </div>

        `;


        chatMessages.appendChild(errorMessage);


        chatMessages.scrollTop =
            chatMessages.scrollHeight;


    });


});



/* ================================= */
/* ENTER İLE MESAJ GÖNDER */
/* ================================= */


chatInput.addEventListener('keydown', function (event) {


    if (event.key === 'Enter') {

        sendMessage.click();

    }


});


</script>


</body>

</html>