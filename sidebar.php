<link href="https://cdn.lineicons.com/5.0/lineicons.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" 
integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap');

    ::after,
    ::before {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
    }

    a {
        text-decoration: none;
    }

    li {
        list-style: none;
    }

    h1 {
        font-weight: 600;
        font-size: 1.5rem;
    }

    body {
        font-family: 'Poppins', sans-serif;
    }

    .wrapper {
        display: flex;
        
    } 

    .main {
        min-height: 100vh;
        width: 100%;
        overflow: hidden;
        transition: all 0.35s ease-in-out;
        /* background-color: #fafbfe; */
        background-color: transparent;
    }

    #sidebar {
        width: 70px;
        z-index: 1000;
        transition: all 0.25s ease-in-out;
        display: flex;
        flex-direction: column;
        background-color: #0e223e;
    }

    #sidebar.expand {
        width: 260px;
        min-width: 260px;
    }

    #toggle-btn {
        background-color: transparent;
        cursor: pointer;
        border: 0;
        padding: 1rem 1.5rem;
    }

    #toggle-btn i {
        font-size: 1.5rem;
        color: #fff;
    }

    .sidebar-logo {
        margin: auto 0;
    }

    .sidebar-logo a {
        color: #fff;
        font-size: 1.15rem;
        font-weight: 600;
    }

    #sidebar:not(.expand) .sidebar-logo,
    #sidebar:not(.expand) a.sidebar-link span {
        display: none;
    }

    .sidebar-nav {
        padding: 2rem 0;
        flex: 1 1 auto;
    }

    a.sidebar-link {
        padding: .625rem 1.625rem;
        color: #fff;
        display: block;
        font-size: 0.9rem;
        white-space: nowrap;
        border-left: 3px solid transparent;
    }

    .sidebar-link i {
        font-size: 1.1rem;
        margin-right: .75rem;
    }

    a.sidebar-link:hover {
        background-color: rgba(255, 255, 255, .075);
        border-left: 3px solid #3b7ddd;
    }

    .sidebar-item {
        position: relative;
    }

    #sidebar:not(.expand) .sidebar-item .sidebar-dropdown {
        position: absolute;
        top: 0;
        left: 70px;
        background-color: #0e2238;
        padding: 0;
        min-width: 15rem;
        display: none;
    }

    #sidebar:not(.expand) .sidebar-item:hover .has-dropdown+.sidebar-dropdown {
        display: block;
        max-height: 15em;
        width: 100%;
        opacity: 1;
    }

    #sidebar.expand .sidebar-link[data-bs-toggle="collapse"]::after {
        border: solid;
        border-width: 0 .075rem .075rem 0;
        content: "";
        display: inline-block;
        padding: 2px;
        position: absolute;
        right: 1.5rem;
        top: 1.4rem;
        transform: rotate(-135deg);
        transition: all .2s ease-out;
    }

    #sidebar.expand .sidebar-link[data-bs-toggle="collapse"].collapsed::after {
        transform: rotate(45deg);
        transition: all .2s ease-out;
    }
</style>

<div class="wrapper">
    <aside id="sidebar">
        <div class="d-flex">
            <button id="toggle-btn" type="button">
                <!-- <i class="lni lni-dashboard-square-1"></i> -->
                <img src="uploads/asset/favicon.ico" width="30px">
            </button>
            <div class="sidebar-logo">
                <a href="#">MyKost</a>
            </div>
        </div>
        <ul class="sidebar-nav">
            <li class="sidebar-item">
                <a href="dashboard.php" class="sidebar-link">
                    <i class="lni lni-home-2"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a href="datakamar.php" class="sidebar-link">
                    <i class="lni lni-agenda"></i>
                    <span>Data Kamar</span>
                </a>
            </li>
            <!-- <li class="sidebar-item">
                <a href="datapenghuni.php" class="sidebar-link">
                    <i class="bi bi-emoji-smile"></i>
                    <span>Data Penghuni</span>
                </a>
            </li> -->
            <li class="sidebar-item">
                <a href="#" class="sidebar-link has-dropdown collapsed" data-bs-toggle="collapse" data-bs-target="#auth" aria-expanded="false" aria-controls="auth">
                    <i class="lni lni-shield-2-check"></i>
                    <span>Pilih Kost</span>
                </a>
                <ul id="auth" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                    <li class="sidebar-item">
                        <a href="athala-kost.php" class="sidebar-link">Athala Kost</a>
                    </li>
                    <li class="sidebar-item">
                        <a href="griyatara2.php" class="sidebar-link">Griya Tara 2</a>
                    </li>
                    <li class="sidebar-item">
                        <a href="griyatarapavilion.php" class="sidebar-link">Griya Tara 1</a>
                    </li>
                </ul>
            </li>
            <li class="sidebar-item">
                <a href="info-tagihan.php" class="sidebar-link">
                    <i class="bi bi-info-circle"></i>
                    <span>Informasi</span>
                </a>
            </li>
            <!-- <li class="sidebar-item">
                <a href="#" class="sidebar-link has-dropdown collapsed" data-bs-toggle="collapse" data-bs-target="#multi" aria-expanded="false" aria-controls="multi">
                    <i class="lni lni-layout-9"></i>
                    <span>Multi Level</span>
                </a>
                <ul id="multi" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                    <li class="sidebar-item">
                        <a href="#" class="sidebar-link collapsed" data-bs-toggle="collapse" data-bs-target="#multi-two" aria-expanded="false" aria-controls="multi-two">
                            Two Links
                        </a>
                        <ul id="multi-two" class="sidebar-dropdown list-unstyled collapse">
                            <li class="sidebar-item">
                                <a href="#" class="sidebar-link">Link 1</a>
                            </li>
                            <li class="sidebar-item">
                                <a href="#" class="sidebar-link">Link 2</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </li> -->
            <!-- <li class="sidebar-item">
                <a href="riwayattransaksi.php" class="sidebar-link">
                    <i class="lni lni-gear-1"></i>
                    <span>Riwayat Transaksi</span>
                </a>
            </li> -->
        </ul>
        <div class="sidebar-footer">
            <a href="logout.php" class="sidebar-link">
                <i class="lni lni-exit"></i>
                <span>Logout</span>
            </a>
        </div>
    </aside>
    <div class="main p-3">
        <!-- <div class="text-center">
            <h1>
                Aplikasi Manajemen Kost
            </h1>
        </div> -->
    </div>
</div>

<script>
    const hamburger = document.querySelector("#toggle-btn");

    hamburger.addEventListener("click",function(){
        document.querySelector("#sidebar").classList.toggle("expand");
    });

</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3-alpha1/dist/js/bootstrap.bundle.min.js"></script>
