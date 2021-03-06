<?php
session_start();
/* Класс Chat содержит публичные статические методы, которые используются в ajax.php */

class Chat
{
    /*
        public static function login($name,$email){
            if(!$name || !$email){
                throw new Exception('Заполните все необх    одимые поля.');
            }
    
            if(!filter_input(INPUT_POST,'email',FILTER_VALIDATE_EMAIL)){
                throw new Exception('Неправильный адрес email.');
            }
    
            // Подготовка кэша gravatar:
            $gravatar = md5(strtolower(trim($email)));
    
            $user = new ChatUser(array(
                'name'		=> $name,
                'gravatar'	=> $gravatar
            ));
    
            // Метод save возвращает объект MySQLi
            if($user->save()->affected_rows != 1){
                throw new Exception('Данное имя используется.');
            }
    
            $_SESSION['user']	= array(
                'name'		=> $name,
                'gravatar'	=> $gravatar
            );
    
            return array(
                'status'	=> 1,
                'name'		=> $name,
                'gravatar'	=> Chat::gravatarFromHash($gravatar)
            );
        }
    
        public static function checkLogged(){
            $response = array('logged' => false);
    
            if($_SESSION['user']['name']){
                $response['logged'] = true;
                $response['loggedAs'] = array(
                    'name'		=> $_SESSION['user']['name'],
                    'gravatar'	=> Chat::gravatarFromHash($_SESSION['user']['gravatar'])
                );
            }
    
            return $response;
        }
    
        public static function logout(){
            DB::query("DELETE FROM kvn_webchat_users WHERE name = '".DB::esc($_SESSION['user']['name'])."'");
    
            $_SESSION = array();
            unset($_SESSION);
    
            return array('status' => 1);
        }
    */
    public static function submitChat($chatText)
    {
        if (!$_SESSION['userid']) {
            throw new Exception('Вы вышли из чата');
        }
        if (!$chatText) {
            throw new Exception('Вы не ввели сообщение.');
        }

        $chat = new ChatLine(array(
            'author'    => $_SESSION['userid'],
            'page'    => $_SERVER[HTTP_REFERER],
            'text'        => $chatText
        ));
    
        // Метод save возвращает объект MySQLi
        $insertID = $chat->save()->insert_id;
    
        return array(
            'status'    => 1,
            'insertID'    => $insertID
        );
    }
    /*
        public static function getUsers(){
            if($_SESSION['user']['name']){
                $user = new ChatUser(array('name' => $_SESSION['user']['name']));
                $user->update();
            }
    
            // Удаляем записи чата страше 5 минут и пользователей, неактивных     в течении 30 секунд
    
            DB::query("DELETE FROM kvn_webchat_lines WHERE ts < SUBTIME(NOW(),'0:5:0')");
            DB::query("DELETE FROM kvn_webchat_users WHERE last_activity < SUBTIME(NOW(),'0:0:30')");
    
            $result = DB::query('SELECT * FROM kvn_webchat_users ORDER BY name ASC LIMIT 20');
    
            $users = array();
            while($user = $result->fetch_object()){
                $user->gravatar = Chat::gravatarFromHash($user->gravatar,30);
                $users[] = $user;
            }
    
            return array(
                'users' => $users,
                'total' => DB::query('SELECT COUNT(*) as cnt FROM kvn_webchat_users')->fetch_object()->cnt
            );
        }
    */



    public static function getChats($lastID)
    {
        $lastID = (int)$lastID;

        $listUsers = $_SESSION['listUsers'];
        /*
              $hdir = $_SERVER['DOCUMENT_ROOT'];
              $fd = fopen("$hdir/modules/chat/1re.txt", 'w') or die("не удалось создать файл");
              $str =$_SERVER[HTTP_REFERER];
              fwrite($fd, $str);
              fclose($fd);
        */

          
        $result = DB::query('SELECT * FROM kvn_webchat_lines WHERE id > '.$lastID.' && page=\''.$_SERVER[HTTP_REFERER].'\' && author in ('.$listUsers.') ORDER BY id ASC');
    
        $chats = array();
        while ($chat = $result->fetch_object()) {
            
            // Возвращаем время создания сообщения в формате GMT (UTC):
            $ymd = $chat->ts;
            $chat->time = $ymd;
      
            /*
                  $chat->time = array(
                    'years'		=> gmdate('Y',strtotime($chat->ts)),
                    'mounts'		=> gmdate('m',strtotime($chat->ts)),
                    'days'		=> gmdate('d',strtotime($chat->ts)),
                      'hours'		=> gmdate('H',strtotime($chat->ts)),
                      'minutes'	=> gmdate('i',strtotime($chat->ts))
                  );
                  */
            $NameUser='';
            $idUser = $chat->author;
            $fio = DB::query('select fio from kvn_performers where id='.$idUser.' limit 1;');
            while ($nameUs = $fio->fetch_object()) {
                $NameUser = $nameUs->fio;
            }
            /*
                  $hdir = $_SERVER['DOCUMENT_ROOT'];
                  file_put_contents("$hdir/modules/chat/1re.txt", print_r($NameUser, true));
            */
            $chat->nameAutor = $NameUser;
            $chats[] = $chat;
        }
    
        return array('chats' => $chats);
    }
    /*
        public static function gravatarFromHash($hash, $size=23){
            return 'http://www.gravatar.com/avatar/'.$hash.'?size='.$size.'&amp;default='.
                    urlencode('http://www.gravatar.com/avatar/ad516503a11cd5ca435acc9bb6523536?size='.$size);
        }
    */
}
