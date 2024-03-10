<?php

?>
<!-- footer section -->

<footer class="footer_section">
  <div class="container">
    <div class="row">
      <div class="col-md-4 footer-col">
        <div class="footer_contact">
          <h4>Contact Us</h4>
          <div class="contact_link_box">
            <a href="">
              <i class="fa fa-map-marker" aria-hidden="true"></i>
              <span>Location:
                <?= $contactInfo['location'] ?>
                <div id="">

                  <iframe
                    style="border: 3px; border-style: solid; margin-left: -12px; border-color: #666; border-radius: 4px;"
                    src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d2540.2946842164642!2d-96.95186500000001!3d50.454237!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0xc39f0d9e10d156e0!2sWhytewold+Emporium!5e0!3m2!1sen!2sca!4v1396556849035"
                    width="100%" height="300"></iframe>
                </div>
              </span>
            </a>
            <a href="tel:<?= $contactInfo['phone'] ?>">
              <i class="fa fa-phone" aria-hidden="true"></i>
              <span>Call:
                <?= $contactInfo['phone'] ?>
              </span>
            </a>
            <a href="mailto:<?= $contactInfo['email'] ?>">
              <i class="fa fa-envelope" aria-hidden="true"></i>
              <span>Email:
                <?= $contactInfo['email'] ?>
              </span>
            </a>
          </div>
        </div>
      </div>
      <div class="col-md-4 footer-col">
        <div class="footer_detail">
          <a href="" class="footer-logo">
            <?= $contactInfo['location'] ?>
          </a>
          <p>

            190 Gimli Rd, Whytewold, Manitoba CANADA R0C 2B0</p>
          <div class="footer_social">
            <!-- Add your social media links here -->
          </div>
        </div>
      </div>
      <div class="col-md-4 footer-col">
        <h4>Opening Hours</h4>
        <p>
          <?= displayOpeningClosingTimes(json_decode($contactInfo['schedule'], true)) ?>
        </p>
      </div>
    </div>
  </div>
</footer>