  <style type="text/css">
    html {
      height: 100%!important;
    }
  </style>
  <main class="px-3 mt-5">
    <h2>Match info</h2>
    <br>
<!-- <div class="card p-0 m-3 w-100" style="background-color: #444550;">
  <div class="card-body block-tour" style="white-space: nowrap;">
    <div class="live">
        <span class="badge bg-primary rounded-pill" style="background-color: red!important;">Live Data</span>
    </div>
    <div class="comand1" style="display: inline-grid;justify-items: center;justify-content: center;">
        <img src="" width="60">
        <p></p>
    </div>
    <div class="score">

    </div>
    <div class="comand2" style="display: inline-grid;justify-items: center;justify-content: center;">
        <img src="<?= $data['logo_cm2'] ?>" width="60" >
        <p></p>
    </div>
    <div class="button-match">

    </div>
  </div>
</div> -->
<div id="status_game">
  
</div>
<br>
<h2><div class="button-match"><a class="btn btn-danger btn-sm" href="/delete/<?= $data_get ?>/" role="button">Delete</a><a style="margin-left: 15px;" class="btn btn-danger btn-sm" href="/reverse/<?= $data_get ?>/" role="button">Перевернуть счёт</a></div></h2>
<br>
<div id="tour_score">
  
</div>
<!-- <div class="card p-0 m-3 w-100" style="background-color: #444550;">
  <div class="card-body block-tour" style="white-space: nowrap;">
    <h2>Match statistics</h2>
    <br>
    <div class="table-responsive">
        <table class="table table-striped table-sm text-white">
          <thead>
            <tr class="text-white">
              <th scope="col">Name</th>
              <th scope="col">ACS</th>
              <th scope="col">K</th>
              <th scope="col">D</th>
              <th scope="col">A</th>
              <th scope="col">+/-</th>
              <th scope="col">ADR</th>
              <th scope="col">HS%</th>
              <th scope="col">FK</th>
              <th scope="col">FD</th>
              <th scope="col">+/-</th>
            </tr>
          </thead>
          <tbody>
            <tr class="text-white">
              <td>1,001</td>
              <td>random</td>
              <td>data</td>
              <td>placeholder</td>
              <td>text</td>
              <td>text</td>
              <td>text</td>
              <td>text</td>
              <td>text</td>
              <td>text</td>
              <td>text</td>
            </tr>
          </tbody>
        </table>
      </div>
</div> -->
<div class="card p-0 m-3 w-100" style="background-color: #444550;">
  <div class="card-body block-tour" style="white-space: nowrap;">
    <h2 id="info_stat">Match statistics</h2>
    <br>
    <div class="table-responsive">
      <table class="table table-striped table-sm text-white">
        <thead>
          <tr class="text-white">
          <th scope="col">Name</th>
          <th scope="col">ACS</th>
          <th scope="col">K</th>
          <th scope="col">D</th>
          <th scope="col">A</th>
          <th scope="col">-/+</th>
          <th scope="col">ADR</th>
          <th scope="col">HS%</th>
          <th scope="col">FK</th>
          <th scope="col">FD</th>
          <th scope="col">+/-</th>
        </tr>
      </thead>
      <tbody id="block_table">
      </tbody>
    </table>
  </div>
</div>
  <div class="card-body block-tour" style="white-space: nowrap;">
    <h2 id="info_stat2">Match statistics</h2>
    <br>
    <div class="table-responsive">
      <table class="table table-striped table-sm text-white">
        <thead>
          <tr class="text-white">
          <th scope="col">Name</th>
          <th scope="col">ACS</th>
          <th scope="col">K</th>
          <th scope="col">D</th>
          <th scope="col">A</th>
          <th scope="col">-/+</th>
          <th scope="col">ADR</th>
          <th scope="col">HS%</th>
          <th scope="col">FK</th>
          <th scope="col">FD</th>
          <th scope="col">+/-</th>
        </tr>
      </thead>
      <tbody id="block_table2">
      </tbody>
    </table>
  </div>
</div>
  </main>
  <footer class="mt-auto text-white-50 t-100">
    <p>Project for Freelancehunt, by <a href="https://freelancehunt.com/freelancer/The_Frix.html" class="text-white">@danil_Kholodnyy</a>.</p>
  </footer>
</div>


    
  </body>
    <script src="<?= $first_level.$_SERVER['SERVER_NAME']?>/public/js/main.js"></script>
</html>