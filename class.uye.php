<?php
/**
 * Created by PhpStorm.
 * User: batuhansaygili
 * Date: 27.05.2016
 * Time: 20:39
 */

class uye {

    protected $tkadi;
    protected $temail;
    protected $tsifre;
    protected $tad;
    protected $tsoyad;

    function __construct($tkadi,$temail,$tsifre, $tad,$tsoyad)
    {
        $this->tkadi = $tkadi;
        $this->temail = $temail;
        $this->tsifre = $tsifre;
        $this->tad = $tad;
        $this->tsoyad = $tsoyad;
    }

    function kayit($db,$query,$kullanici_adi,$sifre,$email,$ad,$soyad){

        //$this->kullanici_adi = $kullanici_adi;
        //$this->sifre = $sifre;
        //$this->email = $email;
        //$this->ad = $ad;
        //$this->soyad = $soyad;


        //$this ->veriler[] = array('kullanici_adi' => $kullanici_adi,'sifre' => $sifre,'email' => $email , 'ad' => $ad , 'soyad' => $soyad );


    }

    /**
     * @param $db
     * @param $query
     * @param $tabloadi
     * @param $kullanici_adi
     * @param $sifre
     * @param $email
     * @param $ad
     * @param $soyad
     * @return string
     */
    public function uyeekle($db, $tabloadi, $kullanici_adi, $sifre, $email, $ad, $soyad){
        if(!empty($kullanici_adi) or !empty($sifre) or !empty($email) or !empty($ad) or !empty($soyad)){

           $dongu = $db->query("select * from $tabloadi where kadi='{$kullanici_adi}'");
           $dongu2 = $db->query("select * from $tabloadi where kadi='{$email}'");
            if ($dongu->rowCount() > 0){
                return 'Bu isim ile kayıtlı kullanıcı bullunmaktadır. <br>';
            }else if($dongu2->rowCount() >0){
                return 'Bu email ile kayıtlı kullanıcı bullunmaktadır. <br>';
            }else if(filter_var($email, FILTER_VALIDATE_EMAIL) === false){
                return 'Geçerli bir eposta giriniz';
            }
            else{
                if(strlen($sifre) < 5){
                    return 'Şifreniz 6 ve 6 karakterden büyük olmak zorundadır ';
                }else if($sifre == '123456' or $sifre == 'qwert' or $sifre == '111111' or $sifre == '123456789' or $sifre == '12345678' or $sifre == 'q1w2e3r4'){
                    return 'Şifreniz basit bir şifre olamaz.';
                }else if(strstr($kullanici_adi,$sifre) or strstr($ad,$sifre) or strstr($soyad,$sifre) ){
                    return 'Şifreniz kullanıcı adınız soyadınız ve şifreniz ile ilgili olamaz';
                }else{
                    $query = "INSERT INTO uye SET $this->tkadi = ?,$this->temail = ?, $this->tsifre = ? , $this->tad = ? , $this->tsoyad= ?";
                    $sorgu = $db->prepare($query);
                    $insert  =  $sorgu->execute(array(
                        $kullanici_adi,$sifre,$email,$ad,$soyad
                    ));
                    if($insert){
                        return 'Başarılı bir şekilde kayıt oldunuz.';
                    }else {
                        return 'Başarısız oldu. Muhtemel hata veritabanı hatası olabilir.';
                    }
                }
            }
        }else {

            return 'Boş Alan Bırakmayınız.';

        }
    }


    function uyeSifreGuncelle($db,$tabloadi,$id,$kullanici_adi,$ad,$soyad,$sifre=0){
        if(!empty($sifre) or !empty($ad) or !empty($soyad)){
            if($sifre != 0){

                if(strlen($sifre) < 5){
                    return 'Şifreniz 6 ve 6 karakterden büyük olmak zorundadır ';
                }else if($sifre == '123456' or $sifre == 'qwert' or $sifre == '111111' or $sifre == '123456789' or $sifre == '12345678' or $sifre == 'q1w2e3r4'){
                    return 'Şifreniz basit bir şifre olamaz.';
                }else if(strstr($kullanici_adi,$sifre) or strstr($ad,$sifre)  or strstr($soyad,$sifre) ){
                    return 'Şifreniz kullanıcı adınız soyadınız ve şifreniz ile ilgili olamaz';
                }else {
                    $query = $db->prepare("UPDATE $tabloadi SET
                    $this->tsifre = :sifre
                    WHERE id = :id");
                    $update = $query->execute(array(
                        "sifre" => $sifre,
                        "id" => $id
                    ));

                    if($update){
                        return 'Başarılı şekil de güncelleme yaptınız.';
                    }else {
                        return 'Güncellerken bir sorun oluştu';
                    }
                }
            }
        }else{
            return 'Boş Alan Bırakmayınız.';
        }

    }



    function listele($db,$query){
        //print_r($this->veriler);
        //foreach($this->veriler as $no => $uye) {
        ////    echo $uye['kullanici_adi'].'<br>';
       // }
        $dongu = $db->query($query);
        if ( $dongu->rowCount() ){
            while( $data = $dongu->fetch( PDO::FETCH_ASSOC ) ){
                echo $data['kadi']."<br />";
            }
        }
    }


}