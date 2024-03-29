<!-- Modal -->
<div class="modal fade" id="wbrUserAgreement" tabindex="-1" aria-labelledby="wbrUserAgreementLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="wbrUserAgreementLabel">Submission guidelines</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p>Before submitting to FajrFair, pelase review our <a href="#">Community Guidelines</a></p>
        <ul>
            <li>Submit good quality content that is engaging to read. </li>
            <li>Only submit content you  own the rights to.</li>
            <li>Use high quality photos that do not have watermarks or are copyrighted.</li>
            <li>Zero tolerance policy towards nudity, violence, or hate</li>
            <li>Respect the intellectual property of others.</li>
            <li>Read the <a href="#"> FajrFair Terms</a></li>
        </ul>
        <p>Our moderators review all submissions before they can bepublished on FajrFair</p>
      </div>
      <div class="modal-footer">
        <form id="ff_user_agreement_form" action="">
            <?php wp_nonce_field( 'ff_user_agreement_nonce', 'ff_user_agreement_nonce_field' ); ?>
            <input id="agreement" name="user_agreement_consent" type="checkbox">
            <label for="agreement">I understand & agree</label>
            <button class="consent_submit" type="submit" name="submit">Start Creating</button>
        </form>
        </div>
    </div>
  </div>
</div>