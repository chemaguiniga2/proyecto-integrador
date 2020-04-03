<h5>These are all of your connected clouds. You will be able to create, manage and monitor all the resources from the clouds connected to your OMP dashboard.</h5>

<div class="row">
  <div class="col-md-12 col-lg-12">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Accounts</h3> <div style="width:80%;"></div>
               <div class="btn-group mt-2 mb-2" slyle="margin-left:60px;padding-left:60px;">
                <button type="button" id="selectcloud" class="btn btn-outline-primary btn-pill dropdown-toggle" data-toggle="dropdown">
                  <span id="selectcloudtext">Add Account</span> <span class="caret"></span>
                </button>
                <ul class="dropdown-menu" role="menu">
                  <li><a href="<?php echo base_url() . 'clouds/addaws' ?>" >AWS Account</a></li>
                  <li><a href="<?php echo base_url() . 'clouds/addazure' ?>" >Azure Account</a></li>
                </ul>
              </div>
      </div>
      <div class="table-responsive">
        <?php if ((count($accounts) > 0)) { ?>
        <table class="table card-table table-vcenter text-nowrap">
          <thead>
            <tr>
              <th>Cloud</th>
              <th>Account</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
          <?php foreach ($accounts as $account) {
            echo '<tr><td><img style="border-radius:5px;" src="' . $account->logo . '" class="header-brand-img" alt="logo"></td>';
            echo '<td>' . $account->name . '</td>';
            echo '<td>' . '<button onclick="swalwredirect(\'' . base_url() . "clouds/remove?id=" . $account->id . '\')" class="btn btn-pill btn-danger-light">Disconnect</button>' . '</td></tr>';
          } ?>

          </tbody>
        </table>
        <?php } else { ?>
          <h4>&nbsp &nbsp &nbsp There are no clouds linked to your OMP account.</h4>

        <?php } ?>
      </div>
      <!-- table-responsive -->
    </div>
  </div>
</div>