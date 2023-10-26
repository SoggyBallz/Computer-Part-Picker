<!DOCTYPE html>
<html>
<head>
  <title>Admin Page</title>
  <link href="style.css" rel="stylesheet" type="text/css" />
</head>

<body>
<header>
    <nav>
      <ul>
        <li><a href="admin.php">Home</a></li>
        <li><a href="adminbuild.php">Build a Computer</a></li>
        <li><a href="components.php">Add Components</a></li>
        <li><a href="adminprebuilds.php">Pre-Builds</a></li>
        <li><div class="dropdown">
            <button class="dropbtn">Profile</button>
            <div class="dropdown-content">
            <a href="profile.php">Profile</a>
            <a href="cart.php">My Cart</a>
            <a href="index.php">Logout</a>
            </div>
        </li>
      </ul>
    </nav>
  </header>
  <main>
    <section id="home">
      <h2 style="color:blue;">Welcome to Computer Part Picker</h2>
      <p>We help you find the best parts for your custom computer build.</p>
      <p>Check our <a href="adminprebuilds.php">Builds</a> section to see pre-made computer configurations.</p>
    </section>
    <section id="builds">
      <h2>Builds</h2>
      <p>Choose a pre-made configuration or use our parts section to find the perfect components for your custom build.
      </p>
    </section>
    <section id="about">
      <h2>About</h2>
      <p>At Computer Part Picker, we're passionate about custom computer building and helping others find the perfect
        parts for their builds. Whether you're a beginner or a seasoned pro, we're here to help.</p>
      <p>Got questions or need advice? Reach out to us via the contact information listed in the <a
          href="admin.php">home</a> section.</p>
      <h2>These are some of our happy clients</h2>
      <img src="images/girts.png" alt="girts" width="100" height="150">
      <img src="images/edgars.png" alt="edgars" width="100" height="150">
      <img src="images/girts2.png" alt="girts2" width="100" height="150">
    </section>
    <section id="contacts">
      <h2>Contacts</h2>
      <ul>
        <li>Email: info@computerpartpicker.com</li>
        <li>Phone: 1-800-123-4567</li>
        <li>Address: 123 Main Street, Anytown USA</li>
      </ul>
    </section>
  </main>
  <footer>
  <div class="footer-container">
    <div class="footer-section">
      <h3>About Us</h3>
      <p>We're passionate about custom computer building and helping others find the perfect parts for their builds. Whether you're a beginner or a seasoned pro, we're here to help.</p>
    </div>
    <div class="footer-section">
      <h4>Contact Us</h4>
      <ul>
        <li>Email: info@computerpartpicker.com</li>
        <li>Phone: 1-800-123-4567</li>
        <li>Address: 123 Main Street, Anytown USA</li>
      </ul>
    </div>
  </div>
  <div class="footer-bottom">
    <p>© 2023 Computer Part Picker. All Rights Reserved.</p>
  </div>
</footer>
</body>
</html>