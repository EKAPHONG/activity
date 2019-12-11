<div class="navbar-custom-menu">
  <ul class="nav navbar-nav">
    <!-- User Account Menu -->
    <li class="dropdown user user-menu">
      <!-- Menu Toggle Button -->

      <?php
      if (isset($_SESSION["session_index"])) {
        ?>
        <span class="visible-xs visible-sm" style="color: #fff; margin-top: 15px; margin-right: 10px">
          <?php echo $_SESSION["account_firstname"] . " " . $_SESSION["account_lastname"]; ?>
        </span>
        <?php
      }
      ?>
    </li>
  </ul>
</div>