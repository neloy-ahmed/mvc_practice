<section class="content">
    <div class="container-fluid">
      <div class="card">
        <div class="card-header">
<form class="form-inline" method="post" action="search">
          <div class="row">
            <!-- <div class="col-md-6"> -->
              <!-- <h3 class="card-title" style="padding-top:5px"><b>Bazar-Grocery</b></h3> -->
              <!-- date range start -->
              <!-- <div class="form-group">
                  <label>Date range:</label>

                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text">
                        <i class="far fa-calendar-alt"></i>
                      </span>
                    </div>
                    <input type="text" class="form-control float-right" id="reservation">
                  </div> -->
                  <!-- /.input group -->
                <!-- </div> -->
              <!-- date range end -->
            <!-- </div> -->
            <!-- <div class="col-md-6 text-right"> -->
              <!-- SEARCH FORM -->

                <div class="form-group mb-2">
                    <label for="reservation">Date range:&nbsp</label>


                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text">
                          <i class="far fa-calendar-alt"></i>
                        </span>
                      </div>
                      <input type="text" name="date_range" value="<?php echo $_POST["date_range"] ?? ''; ?>" class="form-control float-right" id="reservation" autocomplete="off">
                    </div>
                    <!-- /.input group -->
                  </div>
                <!-- date range end -->
            <div class="form-group mx-sm-3 mb-2">
              <label for="user_id" >User:&nbsp</label>
              <input type="text" name="user_id" value="<?php echo $_POST["user_id"] ?? ''; ?>" class="form-control" id="user_id" placeholder="Search by user id">
            </div>
            <button type="submit" class="btn btn-primary mb-2">SEARCH</button>

            <!-- </div> -->
          </div>
</form>
        </div>
        <div class="card-body">
          <table class="table table-striped table-bordered table-responsive">
            <thead>
              <tr>
                <th class="text-center" >#</th>
                <th class="text-center">Amount</th>
                <th>Buyer</th>
                <th>Receipt</th>
                <th>Items</th>
                <th>Buyer E-mail</th>
                <th>Buyer IP</th>
                <th>Note</th>
                <th>City</th>
                <th>Phone</th>
                <th>Entry Date</th>
                <th>Entry By</th>


              </tr>
            </thead>
            <tbody>
<?php
if(isset($purchases) && count($purchases) > 0){
  $i = 1;
foreach ($purchases as $value){
?>
                  <!-- real index page -->
                  <tr>
                    <td class="text-center"><?php echo $i; ?></td>
                    <td class="text-center"><?php echo htmlentities($value['amount']); ?></td>
                    <td><?php echo htmlentities($value['buyer']); ?></td>
                    <td><?php echo $value['receipt_id']; ?></td>
                    <td><?php echo htmlentities($value['items']); ?></td>
                    <td><?php echo htmlentities($value['buyer_email']); ?></td>
                    <td><?php echo htmlentities($value['buyer_ip']); ?></td>
                    <td><?php echo htmlentities($value['note']); ?></td>
                    <td><?php echo htmlentities($value['city']); ?></td>
                    <td><?php echo htmlentities($value['phone']); ?></td>
                    <td><?php echo htmlentities($value['entry_at']); ?></td>
                    <td><?php echo htmlentities($value['entry_by']); ?></td>

                  </tr>

<?php
$i++;
}
// end purchases foreach
}// end of first if

elseif(isset($search_result) && count($search_result) > 0){
  $j = 1;
  foreach ($search_result as $value) { ?>
    <!-- search result -->
    <tr>
      <td class="text-center"><?php echo $j; ?></td>
      <td class="text-center"><?php echo htmlentities($value['amount']); ?></td>
      <td><?php echo htmlentities($value['buyer']); ?></td>
      <td><?php echo $value['receipt_id']; ?></td>
      <td><?php echo htmlentities($value['items']); ?></td>
      <td><?php echo htmlentities($value['buyer_email']); ?></td>
      <td><?php echo htmlentities($value['buyer_ip']); ?></td>
      <td><?php echo htmlentities($value['note']); ?></td>
      <td><?php echo htmlentities($value['city']); ?></td>
      <td><?php echo htmlentities($value['phone']); ?></td>
      <td><?php echo htmlentities($value['entry_at']); ?></td>
      <td><?php echo htmlentities($value['entry_by']); ?></td>

    </tr>




<?php
  $j++;
  }
  // end search_result foreach
}

else{
?>
              <div style="font-size: 1.4em; color: red;">
                  No Data found.
              </div>

<?php
}
// end else
?>

            </tbody>
          </table>

          <br>

        </div>

      </div>
    </div>
  </section>
