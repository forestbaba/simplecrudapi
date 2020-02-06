<?php

if($method == 'GET'){
    if($id){
        $data = DB::query("SELECT * FROM $tableName WHERE id=:id", array(':id'=> $id));
        if($data != null){
            echo json_encode($data);
        }else{
            echo json_encode(['message' => 'Nothing yet']);
        }
    }else{
        $data = DB::query("SELECT * FROM $tableName ");
        echo json_encode($data);
    }
}else if($method == 'POST'){
    if($_POST != null && !$id){
        extract($_POST);
      //  print_r($title);

      DB::query("INSERT INTO $tableName VALUES(null, :title, :body, :author, null)", 
      array(':title' => $title, ':body' => $body, ':author'=>$author));

      $data = DB::query("SELECT *  FROM $tableName ORDER BY id DESC LIMIT 1");
        
      echo json_encode(['message' => 'Post added successfully', 'success' => true, 'post' => $data[0]]);

    }else{
             echo json_encode(['message' => 'Please fill all the fields', 'success' => false]);
 
    }
 
}else if($id){
    $post = DB::query("SELECT * FROM $tableName WHERE id=:id", array(':id'=> $id));
    if($post != null){

        if($method == 'PUT'){

            extract(json_decode(file_get_contents('php://input'), true));
            //print_r($title);
            DB::query("UPDATE $tableName SET title=:title, body=:body, author=:author
                WHERE id =:id", 
            array(':title'=>$title, ':body'=>$body, ':author' => $author, ':id' => $id));

            $data = DB::query("SELECT * FROM $tableName WHERE id =:id", array(':id' => $id));
            echo json_encode(['post'=>$data[0],
             'message'=> 'Post successfully updated', 'success' => true]);

        }elseif($method == 'DELETE'){

            DB::query("DELETE FROM $tableName WHERE id=:id", array(':id' =>$id));
            echo json_encode(['message'=> 'Post deleted sucessfully', 'success'=> true]);

        }

    }else{
             echo json_encode(['message' => 'Post not found', 'success' => false]);

    }
}
//echo 'This is checking out';