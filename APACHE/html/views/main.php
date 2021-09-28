  <main class="px-3 mt-5">
    <h1>Add new match (CS:GO)</h1>
    <br>
    <div class="card p-0 m-3 w-100" style="background-color: #444550;">
                    <div class="row" style="padding: 30px;">
                        <div class="col-12">
                            <form class="form-horizontal mt-3" method="POST">
                                <div class="form-group row ">
                                    <div class="col-12 ">
                                        <input class="form-control form-control-lg" name="comand1" type="text" required=" " placeholder="Comand 1">
                                    </div>
                                </div>
                                <div class="form-group row mt-3">
                                    <div class="col-12 ">
                                        <input class="form-control form-control-lg" name="comand2" type="text" required=" " placeholder="Comand 2">
                                    </div>
                                </div>
                                <div class="form-group row mt-3">
                                    <div class="col-12 ">
                                        <input class="form-control form-control-lg" name="match_key" type="text" required=" " placeholder="Match Key">
                                    </div>
                                </div>

                                <div class="form-group text-center mt-5">
                                    <div class="col-xs-12 pb-3 ">
                                        <button class="btn btn-block btn-lg btn-info " name="do_signup" type="submit ">Add Match</button>
                                    </div>
                                </div>
                                <div class="row">
                                      <div class="col-xs-12 col-sm-12 col-md-12 mt-2 text-center">
                                      <?php if (isset($errors)) { echo array_shift($errors); } ?>
                                    </div>
                                </div>
                            </form>
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