<div class="row">
  <div class="alert alert-warning form-control" id="warningdiv" style="display: none;" role="alert">
    <span class="alert-inner--icon"></span>
    <span class="alert-inner--text" id="warningtext">
    </span>
  </div>
</div>
<div class="row">
  <div class="col-md">
    <div class="card overflow-hidden">
      <div class="card-header">
        <h3 class="card-title">Submit your security questions</h3>
      </div>
      <div class="card-body">
        <div class="row">
          <?php
            $foptions = array('class' => 'form-inline', 'id' => "questionsform", 'onsubmit' => "return validateAnswers()");
            echo form_open('security/validatesq', $foptions)
          ?>
          <div class="col-md-6">
            <div class="form-group overflow-hidden">
            <select name="question1" id="question1" class="form-control custom-select" style="width:100%;">
              <?php foreach ($questions as $question) {
                echo '<option value="' . $question->id . '">' . $question->question . '</option>';
              } ?>
            </select>
            <input style="margin-top:5px;" type="text" class="form-control" name="response1" id="response1" placeholder="Answer 1...">
            </div>
            <div class="form-group mb-md-0 overflow-hidden" style="margin-top:15px;">
            <select name="question2" id="question2" class="form-control custom-select" style="width:100%;">
              <?php foreach ($questions as $question) {
                echo '<option value="' . $question->id . '">' . $question->question . '</option>';
              } ?>
            </select>
            <input style="margin-top:5px;" type="text" class="form-control" name="response2" id="response2" placeholder="Answer 2...">
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group overflow-hidden">
            <select name="question3" id="question3" class="form-control custom-select" style="width:100%;">
              <?php foreach ($questions as $question) {
                echo '<option value="' . $question->id . '">' . $question->question . '</option>';
              } ?>
            </select>
            <input style="margin-top:5px;" type="text" class="form-control" name="response3" id="response3" placeholder="Answer 3...">
            </div>
            <div class="form-group mb-0 overflow-hidden" style="margin-top:15px;">
            <select name="question4" id="question4" class="form-control custom-select" style="width:100%;">
              <?php foreach ($questions as $question) {
                echo '<option value="' . $question->id . '">' . $question->question . '</option>';
              } ?>
            </select>
            <input style="margin-top:5px;" type="text" class="form-control" name="response4" id="response4" placeholder="Answer 4...">
            </div>
          </div>
          
        </div>
        
      </div>
      <div class="card-footer text-right">
        <button type="submit" class="btn btn-primary-light">Save</button>
      </div>
      <?php echo form_close() ?>
    </div>
  </div>
</div>

<script>

  function validateAnswers() {
    
    valid = true
    if (($("#question1").val() == $("#question2").val()) || ($("#question1").val() == $("#question3").val()) || ($("#question1").val() == $("#question4").val())) {
      $("#warningtext").html('All questions must be different')
      $("#warningdiv").show()
      valid = false
      return(valid)
    }

    if (($("#question2").val() == $("#question3").val()) || ($("#question2").val() == $("#question4").val())) {
      $("#warningtext").html('All questions must be different')
      $("#warningdiv").show()
      valid = false
      return(valid)
    }

    if (($("#question3").val() == $("#question4").val())) {
      $("#warningtext").html('All questions must be different')
      $("#warningdiv").show()
      valid = false
      return(valid)
    }

    if(($("#response1").val() == "") || ($("#response2").val() == "") || ($("#response3").val() == "") || ($("#response4").val() == "")) {
      $("#warningtext").html('Please fill all the answers for your questions')
      $("#warningdiv").show()
      valid = false
    }
    
    return(valid)
  }

</script>