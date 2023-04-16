<?php
include_once 'lib/session.php';
session::checkSession();

if (!isset($_GET['sender']) && $_GET['receiver'] == null) {
  echo "<script>window.location='index.php';</script>";
} else {
  $sender = $_GET['sender'];
  $receiver = $_GET['receiver'];
}
?>
<!-- Getting Sender & Receiver Id through hidden inputs -->
<input type="hidden" id="receive" value="<?php echo $receiver; ?>">
<input type="hidden" id="send" value="<?php echo $sender; ?>">
<!-- Getting Sender & Receiver Id through hidden inputs -->

<?php require_once 'inc/header.php'; ?>
<section class="container">
  <div class="main-wrapper">
    <div class="row">
      <div class="col-xl-4">
        <!-- Dynamic Sidebar -->
        <?php include_once 'inc/sidebar.php'; ?>
        <!-- Dynamic Sidebar -->
      </div>
      <div class="col-xl-8">
        <div class="right-panel mb-4">
          <div class="card">
            <div class="card-header">
              <div class="message-to d-flex ">
                <?php

                $query = "SELECT * FROM user WHERE unique_id='$receiver'";
                $result = $db->select($query);
                if ($result) {
                  $receiver = $_GET['receiver'];
                  // PASO 1: Verificar si se ha enviado un archivo
                  if (isset($_FILES['file'])) {
                    // procesar el archivo aquí
                  }
                  // PASO 1: Verificar si se ha enviado un archivo
                  // if(isset($_FILES['file'])) {
                  // PASO 2: Obtener el nombre del archivo
                  // $filename = $_FILES['file']['name'];
                
                  // PASO 3: Guardar el archivo en el servidor
                  //move_uploaded_file($_FILES['file']['tmp_name'], 'uploads/' . $filename);
                
                  // PASO 4: Mostrar un mensaje de éxito
                  //echo "El archivo $filename se ha subido correctamente.";
                  // }//
                
                  foreach ($result as $active_user) { ?>
                    <img src="<?php echo $active_user['img']; ?>">
                    <?php
                    if ($active_user['status'] == "Active") {
                      echo "<i class='fa fa-circle'></i>";
                    } else {
                      echo "<i class='fa fa-circle offline'></i>";
                    }
                    ?>
                    <h6>
                      <?php echo $active_user['username']; ?>
                    </h6>
                    <?php
                    if ($active_user['status'] == "Active") {
                      echo "<p>Active</p>";
                    } else {
                      echo "<p>Offline</p>";
                    }
                    ?>
                  <?php }
                } ?>
              </div>
            </div>
            <div class="card-body">
              <div class="chat-wrapper">
                <div class="chat-body">
                  <div id="chat_load"></div>
                  <script type="text/javascript">
                    $(function  () {
                      const receive = $('#receive').val();
                      const send = $('#send').val();
                      const dataStr = 'receive=' + receive + '&send=' + send;
                      setInterval(functio n () {
                        $.ajax({
                          type: 'GET',
                          url: 'response/chat_loader.php',
                          data: dataStr,
                          success: functi on (e) {
                            $('#chat_load').html(e);
                          }
                        });
                      }, 100);
                    });
                  </script>
                </div>
                <div class="type-chats">
                  <link rel="stylesheet" href="https://unpkg.com/flowbite@1.4.4/dist/flowbite.min.css" />

                  <form method="POST" id="chatForm">
                    <label for="chat" class="sr-only">Your message</label>
                    <div class="flex items-center py-2 px-3 bg-gray-50 rounded-lg dark:bg-gray-700">
                      <button type="button"
                        class="inline-flex justify-center p-2 text-gray-500 rounded-lg cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-600">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                          <path fill-rule="evenodd"
                            d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z"
                            clip-rule="evenodd"></path>
                        </svg>
                      </button>
                      <button type="button"
                        class="p-2 text-gray-500 rounded-lg cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-600">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                          <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zM7 9a1 1 0 100-2 1 1 0 000 2zm7-1a1 1 0 11-2 0 1 1 0 012 0zm-.464 5.535a1 1 0 10-1.415-1.414 3 3 0 01-4.242 0 1 1 0 00-1.415 1.414 5 5 0 007.072 0z"
                            clip-rule="evenodd"></path>
                        </svg>
                      </button>
                      <textarea id="message" rows="1"
                        class="block mx-4 p-2.5 w-full text-sm text-gray-900 bg-white rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-800 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="Your message..."></textarea>
                      <button type="submit" onclick="return chat_validation()"
                        class="inline-flex justify-center p-2 text-blue-600 rounded-full cursor-pointer hover:bg-blue-100 dark:text-blue-500 dark:hover:bg-gray-600">
                        <svg class="w-6 h-6 rotate-90" fill="currentColor" viewBox="0 0 20 20"
                          xmlns="http://www.w3.org/2000/svg">
                          <path
                            d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z">
                          </path>
                        </svg>
                      </button>

                      <span data-testid="clip" data-icon="clip" class=""><svg viewBox="0 0 24 24" height="24" width="24"
                          preserveAspectRatio="xMidYMid meet" class="hover:text-gray-700" version="1.1" x="0px" y="0px"
                          enable-background="new 0 0 24 24" xml:space="preserve">
                          <path fill="currentColor"
                            d="M1.816,15.556v0.002c0,1.502,0.584,2.912,1.646,3.972s2.472,1.647,3.974,1.647 c1.501,0,2.91-0.584,3.972-1.645l9.547-9.548c0.769-0.768,1.147-1.767,1.058-2.817c-0.079-0.968-0.548-1.927-1.319-2.698 c-1.594-1.592-4.068-1.711-5.517-0.262l-7.916,7.915c-0.881,0.881-0.792,2.25,0.214,3.261c0.959,0.958,2.423,1.053,3.263,0.215 c0,0,3.817-3.818,5.511-5.512c0.28-0.28,0.267-0.722,0.053-0.936c-0.08-0.08-0.164-0.164-0.244-0.244 c-0.191-0.191-0.567-0.349-0.957,0.04c-1.699,1.699-5.506,5.506-5.506,5.506c-0.18,0.18-0.635,0.127-0.976-0.214 c-0.098-0.097-0.576-0.613-0.213-0.973l7.915-7.917c0.818-0.817,2.267-0.699,3.23,0.262c0.5,0.501,0.802,1.1,0.849,1.685 c0.051,0.573-0.156,1.111-0.589,1.543l-9.547,9.549c-0.756,0.757-1.761,1.171-2.829,1.171c-1.07,0-2.074-0.417-2.83-1.173 c-0.755-0.755-1.172-1.759-1.172-2.828l0,0c0-1.071,0.415-2.076,1.172-2.83c0,0,5.322-5.324,7.209-7.211 c0.157-0.157,0.264-0.579,0.028-0.814c-0.137-0.137-0.21-0.21-0.342-0.342c-0.2-0.2-0.553-0.263-0.834,0.018 c-1.895,1.895-7.205,7.207-7.205,7.207C2.4,12.645,1.816,14.056,1.816,15.556z">
                          </path>
                        </svg></span>

                      <!-- <input type="file" name="imagen" > -->

                      <!-- <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-500 hover:text-gray-700"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13">
                        </path>
                      </svg> -->
                    </div>
                  </form>

                  <div id="msg"></div>
                  <script type="text/javascript">
                    function chat_validation() {

                      const textmsg = $('#message').val();
                      const receive = $('#receive').val();
                      const send = $('#send').val();

                      if (textmsg == "") {
                        alert('Type Message....');
                        return false;
                      }
                      const datastr = 'message=' + textmsg + '&receive=' + receive + '&send=' + send;
                      $.ajax({
                        url: 'response/chatlog.php',
                        type: 'POST',
                        data: datastr,
                        success: function (e) {
                           $('#msg').html(e);
                        }
                      });
                      document.getElementById('chatForm').reset();
                      return false;
                    }
                  </script>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<?php require_once 'inc/footer.php'; ?>
