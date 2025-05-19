<style>
  #neubar {
    z-index: 1;
    background:rgb(19, 48, 90);
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    box-shadow: 4px 6px 12px rgba(0, 0, 0, 0.4)
  }
  
  #neubar .nav-link:hover {
    border-radius: 6px;
    background: linear-gradient(145deg, #484d57, #3e414e);
    box-shadow:  4px 4px 8px #ddc1a000,
                 -4px -4px 8px #f7e5cc00;
    
  }

  .nav-item .active {
    border-radius: 6px;
    background: linear-gradient(145deg, #484d57, #3e414e);
    box-shadow:  4px 4px 8px #a3570000,
                 -4px -4px 8px #f7e5cc00;
  }

  #neubar .dropdown-menu a:hover {
    color: #454545
  }
  #neubar .nav-item {
    margin : auto 4px;
  }
  #neubar a {
    padding-left:12px;
    padding-right:12px;
    color: white;
  }
  #neubar .dropdown-menu {
    background : #545454
  }
  a.navbar-brand {
    color: #454545
  }
  #home::before {
    content: "";
    display: block;
    height: 80px; 
    margin-top: -80px;
    visibility: hidden;
}
@media (max-width: 1024px) and (min-width: 600px) {
  .navbar-toggler {
    display: block; 
  }

  .navbar-collapse {
    display: none; 
  }

  .navbar-toggler-icon {
    display: block; 
  }
}
</style>

<nav class="navbar navbar-expand-sm navbar-light" id="neubar">
  <div class="container">
    <a class="navbar-brand" href=""><img src="" height="60" /></a>
    <!-- <button class="navbar-toggler" type="button" style="background-color: rgb(192, 192, 192);" 
        data-bs-toggle="collapse" 
        data-bs-target="#navbarNavDropdown" 
        aria-controls="navbarNavDropdown" 
        aria-expanded="false" 
        aria-label="Toggle navigation">
        <span class="navbar-toggler-icon" style="background-color: rgb(192, 192, 192);"></span>
    </button> -->

    <div class=" collapse navbar-collapse" id="navbarNavDropdown">
      <ul class="navbar-nav ms-auto ">
      <h1 style="color: white;">SISTEM MANAJEMEN KOST</h1>
      </ul>
    </div>
  </div>
</nav>
