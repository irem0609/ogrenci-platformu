<aside
    class="sidebar"
    data-theme="<?= esc(session()->get('theme') ?? 'sakura') ?>"
>

    <div class="sidebar-title">
        <strong>Student Platform</strong>
    </div>

    <details class="theme-menu" open>
        <summary>🎨 Temalar</summary>

        <div class="theme-options">

            <button
                type="button"
                class="theme-option sakura-theme"
                data-theme="sakura"
            >
                🌸 Sakura
            </button>

            <button
                type="button"
                class="theme-option dark-theme"
                data-theme="dark"
            >
                🪦 Dark
            </button>

            <button
                type="button"
                class="theme-option ocean-theme"
                data-theme="ocean"
            >
                🌊 Ocean
            </button>

        </div>
    </details>

    <nav>

        <a href="<?= base_url('/student/dashboard') ?>">
            🏠 Dashboard
        </a>

        <a href="<?= base_url('/student/library') ?>">
            📚 Kitaplığım
        </a>

        <a href="<?= base_url('/student/planner') ?>">
            📅 Haftalık Program
        </a>

        <a href="<?= base_url('/student/chatbot') ?>">
            🤖 Chatbot
        </a>

        <a href="<?= base_url('/student/profile') ?>">
            👤 Profil
        </a>

    </nav>

    <div class="sidebar-bottom">

        <a href="<?= base_url('/logout') ?>">
            🚪 Çıkış Yap
        </a>

    </div>

</aside>


<script>

(function () {

    const themeButtons = document.querySelectorAll('.theme-option');
    const sidebar = document.querySelector('.sidebar');

    if (!sidebar) {
        return;
    }


    function applyTheme(theme) {

        /*
         * Geçersiz bir tema gelirse
         * Sakura varsayılan olsun.
         */
        if (
            theme !== 'sakura' &&
            theme !== 'dark' &&
            theme !== 'ocean'
        ) {
            theme = 'sakura';
        }


        /*
         * Sidebar temasını değiştir.
         */
        sidebar.setAttribute('data-theme', theme);


        /*
         * Tüm sayfanın temasını değiştir.
         * Kitaplık, Planner, Chatbot vb.
         * daha sonra bunu kullanabilecek.
         */
        document.body.setAttribute('data-theme', theme);


        /*
         * Temayı tarayıcıda hatırla.
         */
        localStorage.setItem('studentTheme', theme);


        /*
         * Sayfadaki diğer bölümlere
         * "tema değişti" bilgisini gönder.
         *
         * Örneğin Kitaplık:
         * Sakura -> çiçek animasyonu
         * Dark   -> gothic dekorasyon
         * Ocean  -> dalga dekorasyonu
         *
         * kendi içinde karar verebilir.
         */
        window.dispatchEvent(
            new CustomEvent('themeChanged', {
                detail: {
                    theme: theme
                }
            })
        );

    }


    /*
     * Tema butonlarına tıklama.
     */
    themeButtons.forEach(function (button) {

        button.addEventListener('click', function () {

            const selectedTheme = this.dataset.theme;

            applyTheme(selectedTheme);

        });

    });


    /*
     * Daha önce seçilmiş temayı getir.
     *
     * İlk kullanımda Sakura.
     */
    const savedTheme =
        localStorage.getItem('studentTheme') || 'sakura';


    /*
     * Sayfa açılır açılmaz temayı uygula.
     */
    applyTheme(savedTheme);

})();

</script>