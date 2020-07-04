<?php
class purchasesController extends Controller
{
    function index()
    {
        require(ROOT . 'Models/Purchase.php');

        $purchase = new Purchase();

        $data['purchases'] = $purchase->showAllPurchases();
        $this->set($data);
        $this->render("index");
    }

    function create()
    {

      if(isset($_COOKIE['xpeedstudio'])){

        echo "<script> alert('You can submit form only once a day!!! ');
        window.location = 'index';
        </script>";

      }


        if ($_SERVER['REQUEST_METHOD'] == 'POST')
        {

            // Form validation

            $validation_rules = [
                [
                    'fieldName' => 'amount',
                    'type' => 'numeric',
                    'required' => true,
                ],
                [
                    'fieldName' => 'buyer',
                    'type' => 'alpha_neumeric_space',
                    'required' => true,
                ],
                [
                    'fieldName' => 'buyer',
                    'type' => 'max_character',
                    'max_length' => 20,
                    'required' => true,
                ],
                [
                    'fieldName' => 'receipt_id',
                    'type' => 'alpha',
                    'required' => true,
                ],
                [
                    'fieldName' => 'items',
                    'type' => 'alpha_comma_space',
                    'required' => true,
                ],
                [
                    'fieldName' => 'buyer_email',
                    'type' => 'email',
                    'required' => true,
                ],
                [
                    'fieldName' => 'note',
                    'type' => 'max_word',
                    'max_length' => 30,
                    'required' => false,
                ],
                [
                    'fieldName' => 'city',
                    'type' => 'alpha_space',
                    'required' => false,
                ],
                [
                    'fieldName' => 'phone',
                    'type' => 'numeric',
                    'required' => true,
                ],
                [
                    'fieldName' => 'entry_by',
                    'type' => 'numeric',
                    'required' => true,
                ],
            ];

            require(ROOT . 'Data_Cleaning/Validator.php');
            $validator = new Validator();
            $is_valid = $validator->validate($validation_rules, $_POST);
            if(!$is_valid){

              // if there are items in our errors array, return those errors
              $data['success'] = false;
              $data['errors']  = $validator->errors;
            }else{

              require(ROOT . 'Models/Purchase.php');

              $purchase = new Purchase();

              $buyer_ip = $_SERVER['REMOTE_ADDR'];
              $salt = "somesalt";
              $hash_key = hash('sha512',$_POST['receipt_id'].$salt);
              $entry_at = date('Y-m-d');

              $form_fields = array('amount' => $_POST['amount'], 'buyer' => $_POST['buyer'], 'receipt_id' => $_POST['receipt_id'], 'items' => $_POST['items'], 'buyer_email' => $_POST['buyer_email'], 'buyer_ip' => $buyer_ip, 'note' => $_POST['note'], 'city' => $_POST['city'], 'phone' => $_POST['phone'], 'hash_key' => $hash_key, 'entry_at' => $entry_at, 'entry_by' => $_POST['entry_by']);
              // secure form data
              $this->secure_form($form_fields);




              if ($purchase->create($form_fields))
              {
                  // header("Location: " . WEBROOT . "purchases/index");
                  $this->cookieSetter();
                  $data['success'] = true;
                  $data['message'] = 'Success!';

              }

            }

          echo json_encode($data);

        }else{

          //Show the form
          $d['page'] = "purchase_create";
          $this->set($d);

          $this->render("create");
        }


    }

    public function search(){
      if ($_SERVER['REQUEST_METHOD'] == 'POST'){

        $date_range = empty($_POST['date_range']) ?  null : explode('-', $_POST['date_range']) ;
        $start_date=null;
        $end_date=null;

        if($date_range){
          $start_date = new \DateTime($date_range[0]);
          $start_date = date_format($start_date, "Y-m-d");

          $end_date = new \DateTime($date_range[1]);
          $end_date = date_format($end_date, "Y-m-d");
        }


        // require(ROOT . 'Data_Cleaning/Validator.php');
        $validation_rules = [
            [
                'fieldName' => 'date_range',
                'type' => 'valid_date',
                'value' => $start_date,
                'required' => false,
            ],
            [
              'fieldName' => 'date_range',
              'type' => 'valid_date',
              'value' => $end_date,
              'required' => false,
            ],

            [
                'fieldName' => 'user_id',
                'type' => 'numeric',
                'required' => false,
            ],
        ];

        require(ROOT . 'Data_Cleaning/Validator.php');
        $validator = new Validator();
        $is_valid = $validator->validate($validation_rules, $_POST);
        if(!$is_valid){

          // if there are items in our errors array, return those errors
          $data['success'] = false;
          $data['errors']  = $validator->errors;
          $data['search_result'] = null;
          $this->set($data);
          $this->render("index");
        }else{
          //validatin success process form

          $user_id = $_POST['user_id'] ?? null;
          $filters = array();
          $filters['user_id'] = $user_id;
          $filters['start_date'] = $start_date;
          $filters['end_date'] = $end_date;

          // secure form data
          $this->secure_form($filters);


          require(ROOT . 'Models/Purchase.php');

          $purchase = new Purchase();


          $data['search_result'] = $purchase->filterPurchases($filters);
          // die(var_dump($data['search_result']));
          $this->set($data);
          $this->render("index");

        }

      }

    }

    public function cookieSetter(){
      $cookie_name = "xpeedstudio";
      $cookie_value = "The quick brown fox jumps over the lazy dog";
      setcookie($cookie_name, $cookie_value, time()+60*60*24, "/");
    }






}
?>
