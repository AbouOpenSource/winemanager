<?php
 
//$f_host = 'localhost';
//$f_user = 'winemanager';
//$f_pass = 'Password12!';
//$f_bd = 'winemanager';
class SingletonPDO
{
  /**
   * Instance de la classe class SingletonPDO

   *
   * @var SingletonPDO
   * @access private
   */ 
  private $PDOInstance = null;
 
  /**
   * Constante: nom d'utilisateur de la bdd
   *
   * @var string
   */
  const DEFAULT_SQL_USER = 'winemanager';
 
  /**
   * Constante: hôte de la bdd
   *
   * @var string
   */
  const DEFAULT_SQL_HOST = 'localhost';
 
  /**
   * Constante: hôte de la bdd
   *
   * @var string
   */
  const DEFAULT_SQL_PASS = 'Password12!';
 
  /**
   * Constante: nom de la bdd
   *
   * @var string
   */
  const DEFAULT_SQL_DTB = 'winemanager';
 
  /**
   * Constructeur
   *
   * @param void
   * @return void
   * @see PDO::__construct()
   */ 
  public function __construct()
  {
      $this->PDOInstance = new PDO('mysql:dbname='.self::DEFAULT_SQL_DTB.';host='.self::DEFAULT_SQL_HOST,self::DEFAULT_SQL_USER ,self::DEFAULT_SQL_PASS);
  }
}
?>