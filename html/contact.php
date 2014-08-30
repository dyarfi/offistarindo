<?php include('inc_header.php');?>
  <div id="middle">
    <div class="outerwrapper">
      <div class="wrapper">
        <div id="side-menu">
          <h3>CONTACT US</h3>
          <ul>
            <li><a href="contact.php" class="active">Personal Form</a></li>
            <li><a href="contact-02.php">Corporate Form</a></li>
          </ul>
        </div>
        <div id="main-content" class="right">
          <h3>PERSONAL FORM</h3>
          <form action="" method="post" id="contact">
            <table width="100%" border="0" cellpadding="0">
              <tr>
                <td colspan="2">Send an email. All fields with an * are required.</td>
              </tr>
              <tr>
                <td width="150">Name <span>*</span></td>
                <td><label for="textfield"></label>
                  <input type="text" name="textfield" id="textfield" /></td>
              </tr>
              <tr>
                <td>Email <span>*</span></td>
                <td><input type="text" name="textfield2" id="textfield2" /></td>
              </tr>
              <tr>
                <td>Telp <span>*</span></td>
                <td><input type="text" name="textfield3" id="textfield3" /></td>
              </tr>
              <tr>
                <td style="vertical-align:top !important;">Message <span>*</span></td>
                <td><textarea name="textfield4" id="textfield4"></textarea></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td><img src="images/material/captcha.jpg" width="316" height="71" alt="" /></td>
              </tr>
              <tr>
                <td>Please input the code above <span>*</span></td>
                <td><input type="text" name="textfield5" id="textfield5" /></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td><input name="button" type="submit" class="button" id="button" value="Submit" />
                  <input name="button2" type="reset" class="button" id="button2" value="Reset" /></td>
              </tr>
            </table>
          </form>
          <div id="address"><h6>Support Divison</h6>
          <p class="left"> Address: <br />
            Jl. Roa Malaka Utara <br />
            38-38A-38B-38M<br />
            DKI Jakarta 11230<br />
            Indonesia</p>
          <p class="right">Phone	: +65 21 6919676/ 6915075<br />
            Fax		: +65 21 6979677/ 6910923<br />
            Email		: sales@offistarindo.com</p></div>
        </div>
        <div class="clear"></div>
      </div>
    </div>
  </div>
  <!-- end middle -->
  
  <?php include('inc_footer.php');?>
