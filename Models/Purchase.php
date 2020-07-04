<?php
class Purchase extends Model
{
    public function create(array $form_fields)
    {

        $sql = "INSERT INTO demo_table (amount, buyer, receipt_id, items, buyer_email, buyer_ip, note, city, phone, hash_key, entry_at, entry_by) VALUES (:amount, :buyer, :receipt_id, :items, :buyer_email, :buyer_ip, :note, :city, :phone, :hash_key, :entry_at, :entry_by)";

        $req = Database::getBdd()->prepare($sql);

        return $req->execute([
            'amount' => $form_fields['amount'],
            'buyer' => $form_fields['buyer'],
            'receipt_id' => $form_fields['receipt_id'],
            'items' => $form_fields['items'],
            'buyer_email' => $form_fields['buyer_email'],
            'buyer_ip' => $form_fields['buyer_ip'],
            'note' => $form_fields['note'],
            'city' => $form_fields['city'],
            'phone' => $form_fields['phone'],
            'hash_key' => $form_fields['hash_key'],
            'entry_at' => $form_fields['entry_at'],
            'entry_by' => $form_fields['entry_by']

        ]);


    }

    

    public function showAllPurchases()
    {
        $sql = "SELECT * FROM demo_table ORDER BY id DESC";
        $req = Database::getBdd()->prepare($sql);
        $req->execute();
        return $req->fetchAll();
    }

    public function filterPurchases(array $filters){

      $conditions = [];
      $parameters = [];

      if ($filters['user_id']){

            $conditions[] = 'entry_by = ? ';
            $parameters[] = $filters['user_id'];
        }

        if ($filters['start_date'] && $filters['end_date']){

            // BETWEEN
            $conditions[] = 'entry_at BETWEEN ? AND ? ';
            $parameters[] = $filters['start_date'];
            $parameters[] = $filters['end_date'];
        }


        // the base query
        $sql = "SELECT * FROM demo_table ";


        if ($conditions)
        {
            $sql .= " WHERE ".implode(" AND ", $conditions);
        }

        $sql .= "ORDER BY id DESC";

        // die($sql);
        $req = Database::getBdd()->prepare($sql);
        $req->execute($parameters);

        return $req->fetchAll();


    }




}
?>
