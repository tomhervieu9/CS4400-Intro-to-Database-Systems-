<?php
?>
<html><head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
    <script type="text/javascript" src="http://netdna.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
    <link href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="css/look-up-theater.css" rel="stylesheet" type="text/css">
  </head><body>
    <div class="section">
      <div class="container">
        <div class="row">
          <h2>Theater Look-Up</h2>
        </div>
      </div>
    </div>
    <div class="section">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <form role="form">
              <div class="form-group">
                <label class="control-label" for="exampleInputEmail1" contenteditable="true">Zip Code</label>
                <input class="form-control" id="exampleInputEmail1" placeholder="Zip Code" type="text">
              </div>
              <div>
                <div class="text">or
                  <br>
                </div>
              </div>
              <div class="form-group">
                <label class="control-label" for="exampleInputPassword1">City</label>
                <input class="form-control" id="exampleInputPassword1" placeholder="City" type="text">
              </div>
              <button type="submit" class="btn btn-default">Search</button>
            </form>
          </div>
        </div>
      </div>
    </div>
    <div class="container">
      <h2>Results</h2>
      <p>Here's the result based upon your search request</p>
      <table class="table table-condensed">
        <thead>
          <tr>
            <th class="text-center">Theater Name</th>
            <th class="text-center">Address</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>Regal Cinemas 18 - Atlantic Station</td>
            <td>261 19th St NW #1250, Atlanta, GA 30363</td>
          </tr>
          <tr>
            <td>Landmark Theatres - Midtown Art Cinema</td>
            <td>931 Monroe Dr NE, Atlanta, GA 30308</td>
          </tr>
          <tr>
            <td>AMC - Phipps Plaza 14</td>
            <td>3500 Peachtree Rd NE, Atlanta, GA 30326</td>
          </tr>
        </tbody>
      </table>
    </div>
  

</body></html>
