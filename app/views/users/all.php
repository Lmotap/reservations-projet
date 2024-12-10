<?php

if(empty($users)){
  echo '<p>Aucun utilisateur</p>';
}
else{
  foreach ($users as $user) {
    echo '<h2>'. $user->getEmail() .'</h2>';
    echo '<p>'. $user->getPrenom() .'</p>';
  }
}