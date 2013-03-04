<?php
class Intervenant extends Prefab{
  
  function __construct(){
      F3::set('dB',new DB\SQL(
        'mysql:host='.F3::get('db_host').';port='.F3::get('db_port').';dbname='.F3::get('db_server'),
        F3::get('db_user'),
        F3::get('db_pw')));
  }

  function getChilds(){
    $enfantsDB=new DB\SQL\Mapper(F3::get('dB'),'enfant');
    return $enfantsDB->find(NULL,array('order'=>'prenom'));

  }



  function getInterSession($date_debut,$date_fin){
    //A faire 
    //Je suppose qu'il y a un truc du style les récupérer dans la bdd selon l'account ouvert, sinon j'aurai fait ça
    /*
      $session=new DB\SQL\Mapper(F3::get('dB'),'session');
      return $session->load(array('id_intervenant=?',$id_inter))->name; //Avec $id_inter, l'id du mec actuellement connecté.
    */

      return F3::get('dB')->exec(" SELECT DISTINCT session.id_intervenant FROM session WHERE 
                                    session.date_debut = ".$date_debut." AND session.date_fin = ".$date_fin);
  }
  

  function getIdEnfants($id_inter, $date_debut){

    return F3::get('dB')->exec(" SELECT session.id_enfant FROM session WHERE
                                 session.id_intervenant = ".$id_inter." AND   session.date_debut = ".$date_debut);

  }

  function getNomEnfant($id_hs){

    return F3::get('dB')->exec("SELECT enfant.prenom FROM enfant, histoire WHERE id_histoire = ".$id_hs." 
                              AND histoire.id_enfant = enfant.id_enfant ");

  }

  /* 
   * Returns an intervenant object
   */
  function checkLogin($mail, $password) {
    $intervenantsMapper = new DB\SQL\Mapper(F3::get('dB'),'intervenant');
    return $intervenantsMapper->find(array('mail="'.$mail.'" AND mdp="'.$password.'"'));
  }

  /* 
   * Returns an intervenant object
   */
  function getIntervenantById($id) {
    $intervenantsMapper = new DB\SQL\Mapper(F3::get('dB'),'intervenant');
    return $intervenantsMapper->find(array('id_intervenant=?', $id));
  }
    

  function addChild($object , $object2){ //Object est l'enfant, object2 est l'inter connecté
    $enfant=new DB\SQL\Mapper(F3::get('dB'),'enfant');
    $enfant->id_enfant = $object->id_enfant;
    $enfant->prenom = $object->prenom;
    $enfant->mail = $object->mail;
    $enfant->mdp = $object->mdp;
    $enfant->sexe = $object->sexe;
    $enfant->save();
    $session=new DB\SQL\Mapper(F3::get('dB'),'session');
    $session->id_enfant = $object->id_enfant;
    $session->id_inter =  $object2->id_inter;
    $session->save();
  }
  function __destruct(){

  }
}






?>