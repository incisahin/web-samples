-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1
-- Üretim Zamanı: 24 Ağu 2020, 15:19:04
-- Sunucu sürümü: 10.4.11-MariaDB
-- PHP Sürümü: 7.4.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `aslanmobilya`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `anasayfa_slider`
--

CREATE TABLE `anasayfa_slider` (
  `ID` int(11) NOT NULL,
  `Resim` varchar(45) NOT NULL,
  `Baslik` varchar(45) NOT NULL,
  `Yazi` text DEFAULT NULL,
  `Class` varchar(45) DEFAULT NULL,
  `Sira` int(11) NOT NULL DEFAULT 100
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `anasayfa_slider`
--

INSERT INTO `anasayfa_slider` (`ID`, `Resim`, `Baslik`, `Yazi`, `Class`, `Sira`) VALUES
(19, 'slider/c215b446bcdf956d848a8419c1b5a920.webp', '', '', 'pozisyon-orta', 100),
(20, 'slider/f6d9e459b9fbf6dd26c4f7d621adec1d.webp', '', '', 'pozisyon-orta', 100),
(21, 'slider/12fb63ba1566cb03484e1e5e290a73f4.webp', '', '', 'pozisyon-orta', 100);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `personeller`
--

CREATE TABLE `personeller` (
  `ID` int(11) NOT NULL,
  `Adi` varchar(255) NOT NULL,
  `Soyadi` varchar(255) NOT NULL,
  `Eposta` varchar(255) NOT NULL,
  `CepTelefonu` varchar(15) NOT NULL,
  `Parola` varchar(255) NOT NULL,
  `Aktifmi` bit(1) NOT NULL DEFAULT b'1',
  `OlusturmaTarihi` datetime NOT NULL,
  `YetkiID` int(11) NOT NULL DEFAULT 10
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `personeller`
--

INSERT INTO `personeller` (`ID`, `Adi`, `Soyadi`, `Eposta`, `CepTelefonu`, `Parola`, `Aktifmi`, `OlusturmaTarihi`, `YetkiID`) VALUES
(1, 'Abdullah', 'Dalgıç', 'abdullahdalgic33@gmail.com', '905397444700', '67a7895481c29ad8bfd09c6ac5414587', b'1', '2020-01-01 11:11:11', 50),
(3, 'Mustafa', 'Kılcı', 'mustafa@akbimyazilim.com', '905000000000', '7e4f7b98317bcb8fa6df60516dc9d9d3', b'1', '2020-01-01 11:11:11', 50),
(4, 'Kübra', 'Tanrıverdi', 'kubra@akbimyazilim.com', '05000000000', '667624e1d8edd6044d890d684adba726', b'1', '2020-07-28 10:57:50', 50),
(5, 'İnci', 'Oğur', 'inci@akbimyazilim.com', '05000000000', 'e42a5bc745191add81213f5bbbf4fafc', b'1', '2020-08-24 15:31:04', 50);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `personel_log`
--

CREATE TABLE `personel_log` (
  `ID` int(11) NOT NULL,
  `PersonelID` int(11) NOT NULL,
  `GirisZamani` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `personel_yetkiler`
--

CREATE TABLE `personel_yetkiler` (
  `ID` int(11) NOT NULL,
  `YetkiAdi` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `personel_yetkiler`
--

INSERT INTO `personel_yetkiler` (`ID`, `YetkiAdi`) VALUES
(1, 'Personel'),
(20, 'Patron'),
(50, 'Yazılım & Destek');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `sayfa_galeri`
--

CREATE TABLE `sayfa_galeri` (
  `ID` int(11) NOT NULL,
  `UrlID` int(11) NOT NULL,
  `Resim` varchar(255) NOT NULL,
  `Baslik` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `sayfa_galeri`
--

INSERT INTO `sayfa_galeri` (`ID`, `UrlID`, `Resim`, `Baslik`) VALUES
(45, 6, 'galeri/34735e9a2e82874fa73fcfafb7a02dc30533cf12.webp', ''),
(46, 6, 'galeri/e095c5e925528879468c0222eae4674fe26eac56.webp', ''),
(47, 6, 'galeri/4132e3bd5d70aebcf89159b7a6916ab2c8fdd49f.webp', ''),
(48, 6, 'galeri/2c99e467f29b4d7488591b1782522d73a6240e42.webp', 'Test'),
(49, 6, 'galeri/22bf1ac55d6f0fc3f9b476c372a36981c5ed6d99.webp', 'Test'),
(50, 6, 'galeri/22bf1ac55d6f0fc3f9b476c372a36981c5ed6d99_1.webp', 'Test');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `sayfa_iceriktipi`
--

CREATE TABLE `sayfa_iceriktipi` (
  `ID` int(11) NOT NULL,
  `Tip` varchar(45) NOT NULL,
  `Ozellik` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `sayfa_iceriktipi`
--

INSERT INTO `sayfa_iceriktipi` (`ID`, `Tip`, `Ozellik`) VALUES
(1, 'Özel Yapı', NULL),
(5, 'Blog Kategorisi', NULL),
(10, 'Blog', 'text'),
(20, 'Ürün Kategorisi', NULL),
(30, 'Ürün', NULL),
(40, 'Dizayn', NULL),
(50, 'Tekil Galeri', NULL),
(60, 'Çoklu Galeri', NULL),
(100, 'Dış Link', NULL);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `sayfa_url`
--

CREATE TABLE `sayfa_url` (
  `UrlID` int(11) NOT NULL,
  `IcerikTipiID` int(11) NOT NULL,
  `UstID` int(11) NOT NULL DEFAULT 0,
  `SeoUrl` varchar(255) NOT NULL,
  `Baslik` varchar(255) NOT NULL,
  `Desc` varchar(255) DEFAULT NULL,
  `Keyw` varchar(255) DEFAULT NULL,
  `icon` varchar(45) DEFAULT NULL,
  `Resim` varchar(255) DEFAULT NULL,
  `Navbar` int(1) NOT NULL DEFAULT 0,
  `OlusturmaTarihi` datetime NOT NULL DEFAULT current_timestamp(),
  `Sira` int(11) DEFAULT 100,
  `GoruntulemeSayisi` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `sayfa_url`
--

INSERT INTO `sayfa_url` (`UrlID`, `IcerikTipiID`, `UstID`, `SeoUrl`, `Baslik`, `Desc`, `Keyw`, `icon`, `Resim`, `Navbar`, `OlusturmaTarihi`, `Sira`, `GoruntulemeSayisi`) VALUES
(1, 1, 0, 'anasayfa', 'Anasayfa', NULL, NULL, NULL, NULL, 1, '2020-01-01 11:11:11', 10, 0),
(2, 10, 0, 'hakkimizda', 'Hakkımızda', NULL, NULL, NULL, NULL, 1, '2020-01-01 11:11:11', 20, 0),
(3, 1, 0, 'iletisim', 'İletişim', NULL, NULL, NULL, NULL, 1, '2020-01-01 11:11:11', 60, 0),
(4, 30, 0, 'urunler', 'Ürünler', NULL, NULL, NULL, NULL, 0, '2020-01-01 11:11:11', 3, 0),
(6, 50, 0, 'galeri', 'Galeri', NULL, NULL, NULL, NULL, 1, '2020-01-01 11:11:11', 40, 0);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `sayfa_yazi`
--

CREATE TABLE `sayfa_yazi` (
  `ID` int(11) NOT NULL,
  `UrlID` int(11) NOT NULL,
  `Text` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `sayfa_yazi`
--

INSERT INTO `sayfa_yazi` (`ID`, `UrlID`, `Text`) VALUES
(1, 2, '                            <p>                            </p><p>ghgfh</p>                          ');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `site_ayarlar`
--

CREATE TABLE `site_ayarlar` (
  `ID` int(11) NOT NULL,
  `Anahtar` varchar(255) NOT NULL,
  `Deger` varchar(255) NOT NULL,
  `OnYukleme` bit(1) NOT NULL DEFAULT b'0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `site_ayarlar`
--

INSERT INTO `site_ayarlar` (`ID`, `Anahtar`, `Deger`, `OnYukleme`) VALUES
(1, 'site_durum', 'Açık', b'1'),
(2, 'cdn', '//local.h/_Musteri_Dosyalari/AslanMobilya', b'1'),
(3, 'url', '//local.h/_Musteri_Dosyalari/AslanMobilya', b'1'),
(4, 'site_baslik', 'Firma Adı', b'1'),
(5, 'images', 'docs/img', b'1'),
(6, 'sabit_tel', 'Sabit Telefon No', b'1'),
(7, 'cep_tel', 'Cep Telefon No', b'1'),
(8, 'eposta', 'E-Posta Adresi', b'1'),
(9, 'adres', 'Adres', b'1'),
(10, 'site_kisa_bilgi', 'Firma hakkında kısa bilgi.', b'1'),
(11, 'google-site-verification', '', b'1');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `site_mailserver`
--

CREATE TABLE `site_mailserver` (
  `ID` int(11) NOT NULL,
  `SMTPAuth` bit(1) NOT NULL,
  `Host` varchar(45) NOT NULL,
  `Port` varchar(45) NOT NULL,
  `Username` varchar(45) NOT NULL,
  `Username_2` varchar(255) DEFAULT NULL,
  `Password` varchar(45) NOT NULL,
  `SetFromName` varchar(45) NOT NULL,
  `Varsayilan` bit(1) NOT NULL DEFAULT b'0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `site_mailserver`
--

INSERT INTO `site_mailserver` (`ID`, `SMTPAuth`, `Host`, `Port`, `Username`, `Username_2`, `Password`, `SetFromName`, `Varsayilan`) VALUES
(1, b'1', 'mail.domain', '587', 'mail@mailadresi', NULL, 'Parola', 'Gönderen Adı', b'1');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `site_sosyalmedya`
--

CREATE TABLE `site_sosyalmedya` (
  `ID` int(11) NOT NULL,
  `Anahtar` varchar(45) NOT NULL,
  `Deger` varchar(255) DEFAULT NULL,
  `DegerOnEki` varchar(255) DEFAULT NULL,
  `icon` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `site_sosyalmedya`
--

INSERT INTO `site_sosyalmedya` (`ID`, `Anahtar`, `Deger`, `DegerOnEki`, `icon`) VALUES
(1, 'İnstagram', '#', 'https://www.instagram.com/', 'instagram'),
(2, 'Facebook', '#', 'https://www.facebook.com/', 'facebook'),
(3, 'Youtube', '#', 'https://www.facebook.com/', 'youtube'),
(5, 'WhatsApp', '#', 'https://wa.me/', 'whatsapp');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `urun_galeri`
--

CREATE TABLE `urun_galeri` (
  `ID` int(11) NOT NULL,
  `UrunID` int(11) NOT NULL,
  `Resim` varchar(255) NOT NULL,
  `Varsayilan` int(1) NOT NULL DEFAULT 0,
  `Sira` int(11) NOT NULL DEFAULT 100
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `urun_kampanya`
--

CREATE TABLE `urun_kampanya` (
  `ID` int(11) NOT NULL,
  `UrunID` int(11) NOT NULL,
  `TarihBaslangic` datetime DEFAULT NULL,
  `TarihBitis` datetime DEFAULT NULL,
  `KampFiyat` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `urun_kurlari`
--

CREATE TABLE `urun_kurlari` (
  `ID` int(11) NOT NULL,
  `Kur` varchar(45) NOT NULL,
  `Sembol` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `urun_kurlari`
--

INSERT INTO `urun_kurlari` (`ID`, `Kur`, `Sembol`) VALUES
(1, 'Türk Lirası', '₺'),
(2, 'Dolar', '$');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `urun_ozellik_secenek`
--

CREATE TABLE `urun_ozellik_secenek` (
  `ID` int(11) NOT NULL,
  `OzellikID` int(11) NOT NULL,
  `Secenek` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `urun_ozellik_tipleri`
--

CREATE TABLE `urun_ozellik_tipleri` (
  `ID` int(11) NOT NULL,
  `OzellikAdi` varchar(45) NOT NULL,
  `GirisTuru` varchar(45) NOT NULL DEFAULT 'input'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `urun_ozellik_verileri`
--

CREATE TABLE `urun_ozellik_verileri` (
  `ID` int(11) NOT NULL,
  `UrunID` int(11) NOT NULL,
  `OzellikID` int(11) NOT NULL,
  `Veri` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `urun_yapi`
--

CREATE TABLE `urun_yapi` (
  `ID` int(11) NOT NULL,
  `UrlID` int(11) NOT NULL,
  `KategoriID` int(11) DEFAULT NULL COMMENT 'Kategori İd'' leri virgül ile yanyana',
  `Baslik` varchar(255) NOT NULL,
  `Bilgi` text DEFAULT NULL,
  `KisaBilgi` varchar(255) DEFAULT NULL,
  `KurID` int(11) NOT NULL DEFAULT 2,
  `Fiyat` varchar(45) DEFAULT NULL,
  `UrunKodu` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `anasayfa_slider`
--
ALTER TABLE `anasayfa_slider`
  ADD PRIMARY KEY (`ID`);

--
-- Tablo için indeksler `personeller`
--
ALTER TABLE `personeller`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `Index_YetkiID` (`YetkiID`);

--
-- Tablo için indeksler `personel_log`
--
ALTER TABLE `personel_log`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `Index_PersonelID` (`PersonelID`);

--
-- Tablo için indeksler `personel_yetkiler`
--
ALTER TABLE `personel_yetkiler`
  ADD PRIMARY KEY (`ID`);

--
-- Tablo için indeksler `sayfa_galeri`
--
ALTER TABLE `sayfa_galeri`
  ADD PRIMARY KEY (`ID`);

--
-- Tablo için indeksler `sayfa_iceriktipi`
--
ALTER TABLE `sayfa_iceriktipi`
  ADD PRIMARY KEY (`ID`);

--
-- Tablo için indeksler `sayfa_url`
--
ALTER TABLE `sayfa_url`
  ADD PRIMARY KEY (`UrlID`),
  ADD KEY `Index_IcerikTipi` (`IcerikTipiID`),
  ADD KEY `Index_UstID` (`UstID`);

--
-- Tablo için indeksler `sayfa_yazi`
--
ALTER TABLE `sayfa_yazi`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `Index_UrlID` (`UrlID`);

--
-- Tablo için indeksler `site_ayarlar`
--
ALTER TABLE `site_ayarlar`
  ADD PRIMARY KEY (`ID`);

--
-- Tablo için indeksler `site_mailserver`
--
ALTER TABLE `site_mailserver`
  ADD PRIMARY KEY (`ID`);

--
-- Tablo için indeksler `site_sosyalmedya`
--
ALTER TABLE `site_sosyalmedya`
  ADD PRIMARY KEY (`ID`);

--
-- Tablo için indeksler `urun_galeri`
--
ALTER TABLE `urun_galeri`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `UrunID` (`UrunID`);

--
-- Tablo için indeksler `urun_kampanya`
--
ALTER TABLE `urun_kampanya`
  ADD PRIMARY KEY (`ID`);

--
-- Tablo için indeksler `urun_kurlari`
--
ALTER TABLE `urun_kurlari`
  ADD PRIMARY KEY (`ID`);

--
-- Tablo için indeksler `urun_ozellik_secenek`
--
ALTER TABLE `urun_ozellik_secenek`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `Index_OzellikID` (`OzellikID`);

--
-- Tablo için indeksler `urun_ozellik_tipleri`
--
ALTER TABLE `urun_ozellik_tipleri`
  ADD PRIMARY KEY (`ID`);

--
-- Tablo için indeksler `urun_ozellik_verileri`
--
ALTER TABLE `urun_ozellik_verileri`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `Index_UrunID` (`UrunID`),
  ADD KEY `Index_OzellikID` (`OzellikID`);

--
-- Tablo için indeksler `urun_yapi`
--
ALTER TABLE `urun_yapi`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `Index_UrlID` (`UrlID`),
  ADD KEY `Index_KurID` (`KurID`),
  ADD KEY `Index_KategoriID` (`KategoriID`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `anasayfa_slider`
--
ALTER TABLE `anasayfa_slider`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- Tablo için AUTO_INCREMENT değeri `personeller`
--
ALTER TABLE `personeller`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Tablo için AUTO_INCREMENT değeri `personel_log`
--
ALTER TABLE `personel_log`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `personel_yetkiler`
--
ALTER TABLE `personel_yetkiler`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- Tablo için AUTO_INCREMENT değeri `sayfa_galeri`
--
ALTER TABLE `sayfa_galeri`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- Tablo için AUTO_INCREMENT değeri `sayfa_iceriktipi`
--
ALTER TABLE `sayfa_iceriktipi`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;

--
-- Tablo için AUTO_INCREMENT değeri `sayfa_url`
--
ALTER TABLE `sayfa_url`
  MODIFY `UrlID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- Tablo için AUTO_INCREMENT değeri `sayfa_yazi`
--
ALTER TABLE `sayfa_yazi`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Tablo için AUTO_INCREMENT değeri `site_ayarlar`
--
ALTER TABLE `site_ayarlar`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Tablo için AUTO_INCREMENT değeri `site_mailserver`
--
ALTER TABLE `site_mailserver`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Tablo için AUTO_INCREMENT değeri `site_sosyalmedya`
--
ALTER TABLE `site_sosyalmedya`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Tablo için AUTO_INCREMENT değeri `urun_galeri`
--
ALTER TABLE `urun_galeri`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `urun_kampanya`
--
ALTER TABLE `urun_kampanya`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `urun_kurlari`
--
ALTER TABLE `urun_kurlari`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Tablo için AUTO_INCREMENT değeri `urun_ozellik_secenek`
--
ALTER TABLE `urun_ozellik_secenek`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `urun_ozellik_tipleri`
--
ALTER TABLE `urun_ozellik_tipleri`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `urun_ozellik_verileri`
--
ALTER TABLE `urun_ozellik_verileri`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `urun_yapi`
--
ALTER TABLE `urun_yapi`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- Dökümü yapılmış tablolar için kısıtlamalar
--

--
-- Tablo kısıtlamaları `personeller`
--
ALTER TABLE `personeller`
  ADD CONSTRAINT `fk_YetkiID_fkp` FOREIGN KEY (`YetkiID`) REFERENCES `personel_yetkiler` (`ID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Tablo kısıtlamaları `personel_log`
--
ALTER TABLE `personel_log`
  ADD CONSTRAINT `fk_PersonelID_pl` FOREIGN KEY (`PersonelID`) REFERENCES `personeller` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Tablo kısıtlamaları `sayfa_url`
--
ALTER TABLE `sayfa_url`
  ADD CONSTRAINT `fk_IcerikTipi_su` FOREIGN KEY (`IcerikTipiID`) REFERENCES `sayfa_iceriktipi` (`ID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Tablo kısıtlamaları `sayfa_yazi`
--
ALTER TABLE `sayfa_yazi`
  ADD CONSTRAINT `fk_UrlID_y` FOREIGN KEY (`UrlID`) REFERENCES `sayfa_url` (`UrlID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Tablo kısıtlamaları `urun_galeri`
--
ALTER TABLE `urun_galeri`
  ADD CONSTRAINT `fk_UrunID_ug` FOREIGN KEY (`UrunID`) REFERENCES `urun_yapi` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Tablo kısıtlamaları `urun_ozellik_verileri`
--
ALTER TABLE `urun_ozellik_verileri`
  ADD CONSTRAINT `fk_OzellikID_uov` FOREIGN KEY (`OzellikID`) REFERENCES `urun_ozellik_tipleri` (`ID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_UrunID_uov` FOREIGN KEY (`UrunID`) REFERENCES `urun_yapi` (`ID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Tablo kısıtlamaları `urun_yapi`
--
ALTER TABLE `urun_yapi`
  ADD CONSTRAINT `fk_KategroiID_uy` FOREIGN KEY (`KategoriID`) REFERENCES `sayfa_url` (`UrlID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_KurID_uy` FOREIGN KEY (`KurID`) REFERENCES `urun_kurlari` (`ID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_UrlID_uy` FOREIGN KEY (`UrlID`) REFERENCES `sayfa_url` (`UrlID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
