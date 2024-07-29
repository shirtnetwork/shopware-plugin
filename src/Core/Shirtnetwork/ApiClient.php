<?php
/*   __________________________________________________
    |  Obfuscated by YAK Pro - Php Obfuscator  2.0.14  |
    |              on 2024-07-29 10:45:01              |
    |    GitHub: https://github.com/pk-fr/yakpro-po    |
    |__________________________________________________|
*/
 namespace Aggrosoft\Shopware\ShirtnetworkPlugin\Core\Shirtnetwork; use Shopware\Core\Checkout\Order\OrderEntity; use Shopware\Core\Framework\Context; use Shopware\Core\System\SystemConfig\SystemConfigService; use Psr\Cache\CacheItemPoolInterface; class ApiClient { protected $_soapCache = array(); protected $_requestCache = array(); protected $_userIdCache = array(); private $systemConfigService; private $cache; public function __construct(SystemConfigService $OqjcU, CacheItemPoolInterface $bxeXS) { $this->systemConfigService = $OqjcU; $this->cache = $bxeXS; } public function getUserId(string $WhWOa) { goto mBDDg; a_8l2: $this->_userIdCache[$fxELb] = $t4TTn; goto hjBnp; BtTOT: $t4TTn = $this->login($WhWOa, $this->systemConfigService->get("\x53\150\x69\x72\x74\156\x65\164\167\x6f\x72\153\x50\154\165\147\x69\x6e\56\143\x6f\x6e\146\151\x67\56\x75\163\x65\x72\156\x61\155\x65", $WhWOa), md5($this->systemConfigService->get("\123\x68\151\162\164\156\x65\x74\x77\x6f\x72\153\120\x6c\165\147\151\x6e\56\x63\x6f\156\x66\151\147\x2e\160\141\x73\x73\x77\x6f\x72\x64", $WhWOa))); goto a_8l2; mBDDg: $fxELb = $WhWOa ?: "\x64\145\146\x61\x75\154\164"; goto HbLGz; Uh2tI: QVsGT: goto BtTOT; hjBnp: return $t4TTn; goto IdxLE; m5B7C: return $this->_userIdCache[$fxELb]; goto Uh2tI; HbLGz: if (!isset($this->_userIdCache[$fxELb])) { goto QVsGT; } goto m5B7C; IdxLE: } public function login(string $WhWOa, $ywRaJ, $wXTM4) { goto h7yAV; tmZTS: $NsYPT = $this->SOAPRequest($WhWOa, "\x55\163\x65\162\x53\x65\162\x76\x69\x63\x65", "\x73\x69\155\160\154\145\114\157\147\151\x6e", $bURDi, true); goto ghijq; h7yAV: $bURDi = array("\163\125\163\x65\162\116\141\x6d\x65" => $ywRaJ, "\163\x50\x61\x73\163\x77\157\x72\x64" => $wXTM4); goto tmZTS; ghijq: return $NsYPT; goto XisAN; XisAN: } public function getProductById(string $WhWOa, $ekaH5) { goto obemG; Izo4D: return $VNzrS; goto kOwfV; obemG: $bURDi = array("\x69\144" => $ekaH5, "\142\x6c\123\151\155\160\154\x65" => true); goto exTBK; exTBK: $VNzrS = $this->SOAPRequest($WhWOa, "\x50\162\x6f\x64\x75\x63\x74\123\145\162\x76\x69\143\145", "\147\x65\x74\x42\x79\111\x64", $bURDi, true); goto Izo4D; kOwfV: } public function getProductPriceScales(string $WhWOa, $ekaH5) { goto MyMQY; O9pc9: $VNzrS->id = $ekaH5; goto Bi163; MyMQY: $VNzrS = new \stdClass(); goto O9pc9; Bi163: $bURDi = array("\157\x50\162\157\x64\165\143\164" => $VNzrS); goto aUID_; fklZR: return $Hcp3L->source; goto rkuCC; aUID_: $Hcp3L = $this->SOAPRequest($WhWOa, "\120\162\151\143\x65\x53\x63\141\154\x65\x53\x65\x72\166\151\x63\x65", "\x67\x65\x74\x50\162\157\x64\165\x63\164\x50\x72\x69\143\x65\x53\143\x61\154\145\163", $bURDi, true); goto fklZR; rkuCC: } public function getVariantById(string $WhWOa, $DCyb3) { goto ziV0K; ziV0K: $bURDi = array("\151\144" => $DCyb3); goto eVT4V; Cj1PK: return $zJngK; goto B01Rt; eVT4V: $zJngK = $this->SOAPRequest($WhWOa, "\126\141\x72\x69\141\156\x74\x53\145\x72\166\151\x63\x65", "\147\x65\164\x42\x79\111\144", $bURDi, true); goto Cj1PK; B01Rt: } public function getViewsByVariantId(string $WhWOa, $DCyb3) { goto yNG_n; OzjcZ: $bURDi = array("\x6f\x56\x61\x72\151\x61\x6e\164" => $zJngK); goto V3O5q; tQC2M: $zJngK->id = $DCyb3; goto OzjcZ; V3O5q: $cbjkX = $this->SOAPRequest($WhWOa, "\x56\141\162\151\141\156\x74\126\151\145\x77\x53\145\x72\166\x69\x63\145", "\147\x65\164\x56\x69\x65\x77\163\102\171\x56\x61\162\151\x61\x6e\164", $bURDi, true); goto X3iHG; yNG_n: $zJngK = new \stdClass(); goto tQC2M; X3iHG: return $cbjkX->source; goto PNIwv; PNIwv: } public function getViewById(string $WhWOa, $z8O49) { goto xP4A3; f5agM: $C1H8y = $this->SOAPRequest($WhWOa, "\x56\141\162\x69\x61\156\164\126\151\x65\x77\123\145\162\x76\x69\x63\145", "\147\145\164\102\x79\x49\144", $bURDi, true); goto MuGRL; MuGRL: return $C1H8y; goto wyvk6; xP4A3: $bURDi = array("\x69\x64" => $z8O49); goto f5agM; wyvk6: } public function getSizeById(string $WhWOa, $aV0mE) { goto VlvJv; tYOQT: $LRMQ9 = $this->SOAPRequest($WhWOa, "\x53\151\172\145\123\x65\162\x76\151\x63\145", "\x67\x65\164\102\171\x49\x64", $bURDi, true); goto Pv1dU; Pv1dU: return $LRMQ9; goto RKUDi; VlvJv: $bURDi = array("\151\x64" => $aV0mE); goto tYOQT; RKUDi: } public function getSizes(string $WhWOa) { goto XHfm6; jpeJK: return $ptrAF->source; goto xHxXg; aZ70z: $C2PYn->id = $this->getUserId($WhWOa); goto Ziy8X; inDGH: $ptrAF = $this->SOAPRequest($WhWOa, "\123\x69\x7a\x65\x53\x65\x72\x76\x69\x63\145", "\147\x65\x74\125\163\x65\162", $bURDi, true); goto jpeJK; XHfm6: $C2PYn = new \stdClass(); goto aZ70z; Ziy8X: $bURDi = array("\x6f\x55\163\x65\x72" => $C2PYn); goto inDGH; xHxXg: } public function getPrinttypeById(string $WhWOa, $Xp79q) { goto I5WQf; I5WQf: $bURDi = array("\x69\x64" => $Xp79q); goto ZLZWW; ZLZWW: $K4ark = $this->SOAPRequest($WhWOa, "\120\162\151\156\x74\x74\171\x70\145\x53\x65\162\166\x69\x63\x65", "\147\x65\x74\102\x79\x49\x64", $bURDi, true); goto iMQJ0; iMQJ0: return $K4ark; goto AvDwL; AvDwL: } public function getPrinttypeColors(string $WhWOa, $Xp79q) { goto Al6nU; AN1mU: $K4ark->id = $Xp79q; goto nJS0H; Al6nU: $K4ark = new \stdClass(); goto AN1mU; XPvIO: return $rXI6L; goto cEVZq; BqZ4S: $rXI6L = $this->SOAPRequest($WhWOa, "\x43\157\x6c\157\x72\123\x65\162\166\151\x63\145", "\x67\x65\x74\120\162\151\156\x74\x74\x79\x70\145\x43\157\154\157\x72\x73", $bURDi, true); goto XPvIO; nJS0H: $bURDi = array("\157\120\162\x69\156\164\x74\171\160\145" => $K4ark); goto BqZ4S; cEVZq: } public function getLogoById(string $WhWOa = null, $t7_Ca = null) { goto AYYFX; j3Ghe: $SQWlQ = $this->SOAPRequest($WhWOa, "\x4c\157\x67\x6f\x53\145\162\x76\151\143\145", "\147\x65\164\x42\171\x49\144", $bURDi, true); goto DHwsx; DHwsx: return $SQWlQ; goto DayCd; AYYFX: $bURDi = array("\151\x64" => $t7_Ca); goto j3Ghe; DayCd: } public function getLogosByCategory(string $WhWOa, $uZ50P, $fpBXa, $y61KX) { goto LCHsN; HyEiH: return $Y118B->source; goto VpSuG; o9yM6: $bURDi = array("\157\125\x73\x65\162" => $C2PYn, "\157\103\141\x74\145\147\157\162\171" => $v3Odc, "\151\116\165\155\114\x6f\147\x6f\163" => $fpBXa, "\x69\x50\141\147\x65" => $y61KX, "\x62\x6c\116\x6f\x46\x6c\141\x73\x68" => true); goto ekqRd; ekqRd: $Y118B = $this->SOAPRequest($WhWOa, "\x4c\157\x67\157\123\145\162\166\151\x63\x65", "\147\x65\164\125\x73\x65\x72\123\x65\x6c\x65\143\164\145\144\x42\x79\x43\x61\x74\x65\147\x6f\x72\x79", $bURDi, true); goto HyEiH; iSSeV: $v3Odc = new \stdClass(); goto KVjyq; LCHsN: $C2PYn = new \stdClass(); goto D0sGY; D0sGY: $C2PYn->id = $this->getUserId($WhWOa); goto iSSeV; KVjyq: $v3Odc->id = $uZ50P; goto o9yM6; VpSuG: } public function getLogosBySearchTerm(string $WhWOa, $PC3VL, $fpBXa, $y61KX) { goto n31jM; Z5M2c: $C2PYn->id = $this->getUserId($WhWOa); goto Ge1rn; Ge1rn: $bURDi = array("\157\125\x73\145\162" => $C2PYn, "\163\123\145\x61\x72\x63\150\124\x65\x72\x6d" => $PC3VL, "\x69\x4e\x75\155\114\157\147\157\163" => $fpBXa, "\151\120\141\147\145" => $y61KX, "\x62\x6c\116\157\106\x6c\x61\163\150" => true); goto oCQk6; eJ53e: return $Y118B->source; goto mA4Rn; oCQk6: $Y118B = $this->SOAPRequest($WhWOa, "\114\157\147\157\123\x65\162\x76\151\143\x65", "\x67\x65\x74\x55\163\145\x72\x53\145\x6c\x65\x63\x74\145\144\102\x79\x53\x65\x61\162\x63\x68\x54\x65\162\x6d", $bURDi, true); goto eJ53e; n31jM: $C2PYn = new \stdClass(); goto Z5M2c; mA4Rn: } public function getLogoCountByCategory(string $WhWOa, $uZ50P) { goto ImUie; rtzia: $C2PYn->id = $this->getUserId($WhWOa); goto UlobW; AnuPo: return $tTu5L; goto ENnpp; J5bNk: $bURDi = array("\157\x55\163\145\x72" => $C2PYn, "\x6f\103\x61\164\x65\x67\x6f\x72\171" => $v3Odc, "\x62\x6c\x4e\157\x46\154\141\x73\150" => true); goto FsNdn; UlobW: $v3Odc = new \stdClass(); goto gAy8b; FsNdn: $tTu5L = $this->SOAPRequest($WhWOa, "\114\157\147\157\x53\x65\x72\x76\x69\x63\x65", "\147\145\x74\x50\141\147\x65\103\x6f\x75\x6e\x74\x46\x6f\162\x43\141\164\145\147\x6f\162\x79", $bURDi, true); goto AnuPo; ImUie: $C2PYn = new \stdClass(); goto rtzia; gAy8b: $v3Odc->id = $uZ50P; goto J5bNk; ENnpp: } public function getLogoCountBySearchTerm(string $WhWOa, $PC3VL) { goto Q9RUl; H9Rx2: $tTu5L = $this->SOAPRequest($WhWOa, "\x4c\x6f\147\x6f\123\x65\162\x76\x69\143\x65", "\x67\x65\164\120\x61\x67\x65\x43\157\x75\x6e\x74\x46\157\162\x53\x65\141\x72\x63\x68\124\145\162\x6d", $bURDi, true); goto ELhqL; TTBL2: $C2PYn->id = $this->getUserId($WhWOa); goto vXjav; ELhqL: return $tTu5L; goto V4y27; vXjav: $bURDi = array("\x6f\125\x73\145\x72" => $C2PYn, "\163\x53\x65\141\x72\143\x68\x54\x65\x72\x6d" => $PC3VL, "\142\154\x4e\x6f\x46\154\x61\163\150" => true); goto H9Rx2; Q9RUl: $C2PYn = new \stdClass(); goto TTBL2; V4y27: } public function getLogoCategories(string $WhWOa) { goto Knk5I; vMKq9: $s9dP3 = $this->SOAPRequest($WhWOa, "\x4c\x6f\x67\157\103\141\x74\x65\147\157\x72\171\123\x65\162\166\x69\x63\x65", "\x67\x65\x74\x55\163\x65\162\x53\x65\154\145\x63\164\x65\x64", $bURDi, true); goto uhL2k; NZukg: $bURDi = array("\x6f\x55\x73\145\162" => $C2PYn, "\142\x6c\x4e\x6f\x46\154\141\x73\150" => true); goto vMKq9; EeBru: $C2PYn->id = $this->getUserId($WhWOa); goto NZukg; Knk5I: $C2PYn = new \stdClass(); goto EeBru; uhL2k: return $s9dP3->source; goto uCz3X; uCz3X: } public function getFirstLogoCategory(string $WhWOa) { return $this->getLogoCategories($WhWOa)[0]; } public function getCoins(string $WhWOa) { goto TwNih; fwizF: return $SQQJH; goto fXf_U; bcmc0: $SQQJH = $this->SOAPRequest($WhWOa, "\x55\x73\x65\162\x53\145\x72\166\151\x63\145", "\x67\x65\164\x43\157\151\156\x73", $bURDi, false, true); goto fwizF; ccMS4: $bURDi = array("\x6f\125\163\x65\x72" => $C2PYn); goto bcmc0; vfb4E: $C2PYn->id = $this->systemConfigService->get("\123\x68\151\x72\164\156\x65\x74\x77\x6f\x72\153\x50\x6c\165\x67\x69\x6e\56\x63\157\x6e\146\x69\147\56\x75\163\x65\x72\151\144"); goto ccMS4; TwNih: $C2PYn = new \stdClass(); goto vfb4E; fXf_U: } public function SOAPRequest($WhWOa, $Z2CkO, $W09tG, $xTaHw, $bxeXS = false, $F7Msg = false) { goto Slht3; vo_fS: $this->_soapCache[$fxELb] = $JUMzn; goto imxLp; L5hpV: $SC20z->password = $this->systemConfigService->get("\123\x68\151\x72\164\156\x65\164\x77\x6f\162\x6b\120\x6c\165\x67\x69\156\56\143\157\156\146\151\147\56\x70\141\163\x73\167\x6f\162\x64", $WhWOa); goto ZoqU6; tTu21: $HbSIT->__setSoapHeaders(array($Z5GKG)); goto uyWeU; XFUuU: try { $JUMzn = call_user_func_array(array($HbSIT, $W09tG), $xTaHw); } catch (\SoapFault $p4wA1) { return null; } goto vo_fS; Slht3: $fxELb = md5("\163\x68\151\162\x74\156\x65\164\167\157\162\x6b\x73\x6f\141\x70" . $Z2CkO . $W09tG . serialize($xTaHw)); goto PIIJz; ZoqU6: $Z5GKG = new \SoapHeader("\150\164\x74\160\x3a\57\57\141\160\x69\56\x73\150\x69\162\x74\x6e\145\x74\x77\x6f\x72\x6b\x2e\x64\145\x2f\x73\x6f\141\160\57\77\163\x65\162\166\151\143\145\x3d" . $Z2CkO, "\x61\x75\164\150\x65\x6e\x74\x69\143\x61\164\x65", $SC20z); goto tTu21; T_aId: if (!($bxeXS && $YuH1Z->isHit() && $YuH1Z->get())) { goto eit9z; } goto CtP4q; CtP4q: return $YuH1Z->get(); goto cbewp; uyWeU: JZyfB: goto XFUuU; j9mAO: xmgJ_: goto VwcTc; c9C5v: $SC20z = new \stdClass(); goto K5dIy; imxLp: if (!($bxeXS && $JUMzn)) { goto pvWan; } goto dtUYH; dtUYH: $YuH1Z->set($JUMzn); goto PQABM; PIIJz: $YuH1Z = $this->cache->getItem($fxELb); goto T_aId; viVOX: if (!$F7Msg) { goto JZyfB; } goto c9C5v; BdncQ: if (!isset($this->_soapCache[$fxELb])) { goto xmgJ_; } goto PtX8T; m_W2A: return $JUMzn; goto BtYG7; K5dIy: $SC20z->username = $this->systemConfigService->get("\123\x68\x69\162\x74\x6e\145\x74\167\157\162\x6b\120\x6c\165\x67\151\x6e\56\143\157\156\x66\151\147\56\165\x73\145\162\x6e\141\x6d\145", $WhWOa); goto L5hpV; PQABM: $this->cache->save($YuH1Z); goto hi0D1; PtX8T: return $this->_soapCache[$fxELb]; goto j9mAO; VwcTc: $HbSIT = new \SoapClient("\x68\164\164\160\x3a\x2f\57\x61\160\x69\56\x73\150\x69\162\x74\156\x65\164\x77\x6f\162\153\x2e\x64\x65\57\163\157\x61\x70\x2f\77\x73\x65\x72\x76\151\143\x65\x3d{$Z2CkO}\x26\167\x73\x64\154\x3d\61"); goto viVOX; cbewp: eit9z: goto BdncQ; hi0D1: pvWan: goto m_W2A; BtYG7: } public function getConfig(string $WhWOa, $dKTKU) { goto PCC0m; eYAHe: $this->cache->save($YuH1Z); goto SIlJs; NkRGz: $lczot = $this->GETRequest($cRnaz); goto IIPjz; D9pTy: return json_decode(unserialize($YuH1Z->get())); goto WKonA; SIlJs: return json_decode($lczot); goto XfCwY; IIPjz: $YuH1Z->set(serialize($lczot)); goto eYAHe; PCC0m: $fxELb = md5("\163\150\151\x72\164\x6e\145\164\x77\157\x72\x6b\143\x6f\x6e\x66\x69\x67" . $dKTKU); goto van23; WKonA: lkbuL: goto Irc_H; vxwg7: $cRnaz .= "\57\143\157\x6e\146\x69\147\x2f" . $dKTKU; goto NkRGz; van23: $YuH1Z = $this->cache->getItem($fxELb); goto QDeEV; QDeEV: if (!($YuH1Z->isHit() && $YuH1Z->get())) { goto lkbuL; } goto D9pTy; Irc_H: $cRnaz = $this->systemConfigService->get("\x53\150\x69\162\164\x6e\x65\164\167\x6f\x72\x6b\120\x6c\165\x67\x69\x6e\56\x63\157\156\x66\x69\147\x2e\143\x6f\156\x66\151\x67\x73\145\x72\166\145\162", $WhWOa); goto vxwg7; XfCwY: } public function getConfigServerUrl(string $WhWOa) { return $this->systemConfigService->get("\123\150\x69\x72\x74\156\x65\164\167\x6f\x72\153\120\x6c\x75\147\x69\x6e\x2e\143\157\x6e\146\151\x67\x2e\x63\157\156\146\151\147\163\145\162\166\x65\162", $WhWOa); } public function getSOAPUserObject(string $WhWOa) { return array("\151\144" => $this->getUserId($WhWOa)); } public function getRest($RGegB) { return json_decode($this->GETRequest("\x68\164\164\160\x3a\x2f\57\x61\x70\151\x2e\x73\150\x69\x72\x74\x6e\x65\x74\167\x6f\162\x6b\x2e\x64\x65\57\162\145\x73\x74\57" . $RGegB)); } public function GETRequest($IxFts) { goto k_TMa; ocWWG: curl_setopt($QHzs0, CURLOPT_RETURNTRANSFER, 1); goto ESjIW; NmAUT: curl_setopt($QHzs0, CURLOPT_POST, 0); goto ocWWG; ESjIW: $zdPNF = curl_exec($QHzs0); goto XFZjC; GWuuW: if (!isset($this->_requestCache[$fxELb])) { goto XRD8S; } goto UBz8S; uvoc2: return $zdPNF; goto E01fE; VPETi: $this->_requestCache[$fxELb] = $zdPNF; goto uvoc2; j_8HQ: $zdPNF = trim($zdPNF); goto VPETi; IyR7r: $QHzs0 = curl_init(); goto w1bB6; w1bB6: curl_setopt($QHzs0, CURLOPT_URL, $IxFts); goto NmAUT; UBz8S: return $this->_requestCache[$fxELb]; goto O57jR; O57jR: XRD8S: goto IyR7r; k_TMa: $fxELb = md5($IxFts); goto GWuuW; XFZjC: curl_close($QHzs0); goto j_8HQ; E01fE: } public function POSTRequest($IxFts, $xkUQD) { goto h7rnn; CNpsV: curl_close($QHzs0); goto VVRjt; E0qUC: $zdPNF = curl_exec($QHzs0); goto CNpsV; KeKqx: curl_setopt($QHzs0, CURLOPT_RETURNTRANSFER, 1); goto IaT6_; VVRjt: $zdPNF = trim($zdPNF); goto uGCS_; h7rnn: $QHzs0 = curl_init(); goto IBDd_; IaT6_: curl_setopt($QHzs0, CURLOPT_POSTFIELDS, http_build_query($xkUQD)); goto E0qUC; IBDd_: curl_setopt($QHzs0, CURLOPT_URL, $IxFts); goto TzWXO; TzWXO: curl_setopt($QHzs0, CURLOPT_POST, 1); goto KeKqx; uGCS_: return $zdPNF; goto zsNFD; zsNFD: } public function getAssetUrl(string $WhWOa, $EM96S, $uG3v4) { $r0lkq = $this->getUserId($WhWOa); return "\x68\x74\x74\160\163\x3a\57\57\141\160\151\x2e\x73\150\x69\x72\164\x6e\145\164\167\157\x72\x6b\56\x64\x65\x2f\x6f\165\164\x2f" . $EM96S . "\57" . $r0lkq . "\57" . $uG3v4; } public function bookCoins(string $WhWOa, $po6j8, $aZBUQ, $CYJkN = 0, $e86AG = 0) { goto wMk_6; tk2S1: $lXmGE = $this->systemConfigService->get("\x53\x68\151\162\164\156\145\x74\167\x6f\x72\153\120\x6c\165\147\x69\156\56\x63\x6f\x6e\146\151\147\x2e\160\141\163\x73\x77\157\162\144", $WhWOa); goto rRb05; lz1u0: $zdPNF = curl_exec($QHzs0); goto iECm0; FP2uF: curl_setopt($QHzs0, CURLOPT_RETURNTRANSFER, 1); goto A6ht6; rRb05: $QHzs0 = curl_init(); goto wPo1C; Cjq27: $zdPNF = trim($zdPNF); goto zj65E; wPo1C: $shuYv = "\150\164\x74\x70\72\57\x2f\141\160\151\56\163\x68\151\x72\164\x6e\145\164\x77\157\x72\153\56\x64\x65\57\163\150\151\x72\x74\156\x65\164\167\157\x72\x6b\x2f\142\x6f\157\x6b\x2e\x6a\163\x70"; goto fYUcD; HVem0: curl_setopt($QHzs0, CURLOPT_POST, 1); goto FP2uF; A6ht6: curl_setopt($QHzs0, CURLOPT_POSTFIELDS, "\x75\163\x65\x72\x6e\x61\155\145\75" . $OFM5s . "\46\160\x61\x73\x73\167\x6f\162\x64\x3d" . md5($lXmGE) . "\46\161\165\x61\156\x74\151\164\171\x3d" . $po6j8 . "\x26\x6b\145\x79\x3d" . $aZBUQ . "\x26\141\146\x66\x69\154\141\x74\145\x3d" . $CYJkN . "\x26\x70\162\157\166\x69\163\151\x6f\156\75" . $e86AG); goto lz1u0; iECm0: curl_close($QHzs0); goto Cjq27; wMk_6: $OFM5s = $this->systemConfigService->get("\x53\x68\151\162\164\x6e\145\164\167\157\162\x6b\120\154\165\x67\x69\156\x2e\x63\157\x6e\146\x69\x67\x2e\x75\163\145\x72\x6e\x61\x6d\x65", $WhWOa); goto tk2S1; fYUcD: curl_setopt($QHzs0, CURLOPT_URL, $shuYv); goto HVem0; zj65E: $this->bookLog($po6j8, $aZBUQ, $zdPNF, $e86AG); goto ZHvWP; ZHvWP: return trim($zdPNF); goto kL5Gq; kL5Gq: } public function bookLog($M9XFq, $aZBUQ, $JUMzn, $e86AG) { goto fpF5z; fpF5z: $mCZpr = "\x23\43\43\43\x23\43\43\x23\x23\x23\x23\x23\43\x23\43\x23\43\x23\43\43\x23\43\43\x23\43\x23\x23\43\43\43\x23\43\43\43\43\x23\43\x23\43\x23\x23\43\x23" . "\xa"; goto Ly3OQ; nIyat: $mCZpr .= "\x51\165\141\156\x74\151\x74\171\72\40{$M9XFq}\54\40\x4f\162\x64\x65\x72\153\x65\x79\72\x20{$aZBUQ}\x2c\x20\x50\162\x6f\166\151\x73\151\x6f\x6e\72\40{$e86AG}\12"; goto lo294; lo294: $mCZpr .= "\x2a\52\52\x2a\52\52\52\52\x2a\52\x2a\x2a\52\x2a\x2a\52\52\52\x2a\x2a\52\52\x2a\x2a\52\52\x2a\x2a\x2a\52\52\x2a\x2a\52\x2a\52\52\52\x2a\52\52\x2a\x2a" . "\12"; goto MTt1f; Ly3OQ: $mCZpr .= "\133" . date("\x6d\57\x64\57\x59\40\x67\x3a\151\x20\101") . "\x5d\40\55\40" . "\102\157\x6f\x6b\x69\156\147\40\x72\145\163\165\154\x74\x3a\x20{$JUMzn}" . "\12"; goto nIyat; MTt1f: } public function manifestOrder(string $WhWOa, $gbNdk) { goto iIDwq; sw9jy: $cRnaz .= "\x2f\157\162\x64\x65\x72"; goto j4y5t; kiqDC: $qBcGW = ["\157\x72\x64\x65\x72\x5f\x69\144" => $gbNdk->getOrderNumber(), "\x6f\x72\x64\x65\162\x5f\x64\141\x74\x65" => $gbNdk->getOrderDateTime()->format("\131\x2d\155\55\144\40\x48\x3a\x69\72\x73"), "\143\165\163\x74\x6f\x6d\145\162\137\x6e\141\155\x65" => $dzSZE->getFirstName() . "\x20" . $dzSZE->getLastName(), "\143\157\156\x66\151\x67\163" => $uLN42, "\x61\x6d\x6f\x75\x6e\164\x73" => $SfPpp]; goto lCylE; j4y5t: $this->POSTRequest($cRnaz, $qBcGW); goto jQ1jp; djw02: $dzSZE = $gbNdk->getOrderCustomer(); goto kiqDC; iIDwq: $xstiW = $gbNdk->getLineItems(); goto OjeC_; lCylE: $cRnaz = $this->systemConfigService->get("\123\x68\x69\162\x74\x6e\x65\164\x77\157\x72\x6b\120\154\x75\x67\x69\x6e\x2e\x63\157\x6e\x66\151\x67\56\143\x6f\156\146\x69\147\163\x65\x72\166\145\x72", $WhWOa); goto sw9jy; UVaSY: v0YB1: goto djw02; oWH40: foreach ($xstiW as $pj6xd) { goto Y9qbp; aOc_j: if (!isset($w9Z1y["\x73\x68\x69\162\x74\156\145\164\167\157\x72\x6b"])) { goto ePG5O; } goto mh_4X; dmdqb: $SfPpp[] = $pj6xd->getQuantity(); goto UwZhT; mh_4X: $uLN42[] = $w9Z1y["\x73\x68\x69\162\164\156\145\164\167\157\162\x6b"]; goto dmdqb; OLnxZ: Wf2N6: goto BubZ5; idVM7: koEkU: goto r6xsI; UwZhT: $dKTKU = $this->getConfig($WhWOa, $w9Z1y["\163\150\151\162\x74\x6e\145\164\x77\157\x72\x6b"]); goto ZVyMB; r6xsI: ePG5O: goto OLnxZ; Y9qbp: $w9Z1y = $pj6xd->getPayload(); goto aOc_j; ZVyMB: foreach ($dKTKU->objects as $AYxsx) { goto sNSch; jEraj: vrC94: goto eleki; sNSch: if (!($AYxsx->type === "\x75\x73\145\x72\x2d\154\x6f\x67\157")) { goto Klk3p; } goto uRAfP; hf5Qr: $aQVTa = array_pop($YBRl7); goto eOcSD; BiZ1M: Klk3p: goto jEraj; eOcSD: $this->manifestUpload($WhWOa, $aQVTa); goto BiZ1M; uRAfP: $YBRl7 = explode("\x2f", $AYxsx->meta->original); goto hf5Qr; eleki: } goto idVM7; BubZ5: } goto UVaSY; We6FL: $SfPpp = []; goto oWH40; OjeC_: $uLN42 = []; goto We6FL; jQ1jp: } public function getResourceLink(string $WhWOa, $EM96S, $YBRl7) { goto rn4xj; rn4xj: $pEhhr = "\x68\x74\x74\160\x3a\57\x2f\x61\x70\x69\x2e\163\150\x69\x72\x74\156\x65\164\x77\157\162\153\56\x64\x65"; goto CF5Ev; NUzPL: $pEhhr .= $this->getUserId($WhWOa) . "\x2f"; goto Rcd5o; YWX02: $pEhhr .= "{$EM96S}\57"; goto NUzPL; Rcd5o: $pEhhr .= $YBRl7; goto H0PIw; CF5Ev: $pEhhr .= "\x2f\x6f\165\164\57"; goto YWX02; H0PIw: return $pEhhr; goto fnKLR; fnKLR: } public function manifestUpload(string $WhWOa, $Nqqmh) { goto e9JKS; SPobF: $cRnaz .= "\x2f\155\141\156\151\146\145\163\164\x2f" . $Nqqmh; goto JidZ9; JidZ9: $tLKZu = $this->GETRequest($cRnaz); goto c1YQK; e9JKS: $cRnaz = str_replace("\x2f\x66\x69\x6c\x65\163", '', $this->systemConfigService->get("\123\150\151\162\164\x6e\145\x74\167\157\x72\x6b\120\x6c\165\147\x69\156\56\x63\157\156\x66\x69\x67\x2e\x75\160\x6c\157\141\x64\x73\145\162\166\x65\x72", $WhWOa)); goto SPobF; c1YQK: } public function currencyConvert($j4xa9, $iOc8I, $oL7Gz = 0) { goto dewca; kU4xr: $IxFts = str_replace("\x7b\x7b\x43\125\x52\122\x45\116\x43\x59\x5f\x54\117\175\x7d", $iOc8I, $IxFts); goto Y82tO; Y82tO: try { goto hmw6p; CX5Pd: if ($xg3HB) { goto bihT1; } goto Cuitr; QeQM1: bihT1: goto nnh5u; nnh5u: return (float) $xg3HB * 1.0; goto qgmQ4; Cuitr: return null; goto QeQM1; hmw6p: $xg3HB = $this->redir_curl($IxFts); goto CX5Pd; qgmQ4: } catch (Exception $rpqTE) { goto UWTtQ; UWTtQ: if (!($oL7Gz == 0)) { goto rTPn7; } goto X1wfG; ItHm_: rTPn7: goto Pj4Sf; X1wfG: return $this->currencyConvert($j4xa9, $iOc8I, 1); goto ItHm_; Pj4Sf: } goto KixPR; dewca: $IxFts = str_replace("\173\x7b\103\125\122\x52\105\x4e\103\x59\137\x46\x52\117\115\x7d\x7d", $j4xa9, "\x68\x74\164\160\72\57\x2f\x71\x75\x6f\164\x65\56\x79\x61\x68\157\157\56\x63\157\155\57\x64\x2f\161\165\x6f\x74\145\x73\x2e\143\x73\x76\77\163\x3d\173\x7b\103\x55\122\122\x45\116\103\x59\x5f\106\x52\117\x4d\x7d\x7d\x7b\x7b\x43\x55\x52\x52\105\116\103\131\137\124\x4f\175\175\75\x58\46\146\75\x6c\61\x26\x65\75\x2e\x63\x73\166"); goto kU4xr; KixPR: } private function redir_curl($IxFts) { goto v8hnp; ZwRHL: return $iPMWZ; goto v0S13; YSl35: $iPMWZ = $this->curl_redir_exec($YxsAN); goto OQD5W; HAQZb: curl_setopt($YxsAN, CURLOPT_URL, $IxFts); goto f7YeE; v8hnp: $YxsAN = curl_init($IxFts); goto HAQZb; ySlf4: XI4mU: goto sLQ7y; f7YeE: if (ini_get("\157\160\x65\x6e\x5f\x62\141\163\145\x64\x69\x72") == '' && ini_get("\163\141\146\145\x5f\155\157\x64\x65" == "\x4f\146\x66")) { goto XI4mU; } goto YSl35; yUwUh: Q0BK1: goto MxcYn; MxcYn: curl_close($YxsAN); goto ZwRHL; OQD5W: goto Q0BK1; goto ySlf4; sLQ7y: curl_setopt($YxsAN, CURLOPT_FOLLOWLOCATION, NWwVZ); goto UWN1E; UWN1E: $iPMWZ = curl_exec($YxsAN); goto yUwUh; v0S13: } private function curl_redir_exec($QHzs0) { goto hdzph; A8sBo: if ($IxFts["\x70\x61\164\x68"]) { goto ULN7B; } goto qT26D; oosfR: Z510S: goto ekcf5; f6BUU: DOgqV: goto C1DfE; rPhdq: preg_match("\57\x4c\x6f\143\x61\x74\151\157\x6e\x3a\x28\56\52\77\51\x5c\x6e\x2f", $iWXTM, $Fy3aO); goto U2d8g; XSZgu: DTEY2: goto ERihC; uT3Te: list($iWXTM, $MxwHT) = explode("\xa\15", $MxwHT, 2); goto fOLRr; U2d8g: $IxFts = @parse_url(trim(array_pop($Fy3aO))); goto ew4uL; C1DfE: $Fy3aO = array(); goto rPhdq; ZGkmS: if ($UJd13 == 301 || $UJd13 == 302) { goto DOgqV; } goto YhQR2; XYXce: goto DTEY2; goto f6BUU; YhQR2: $Zad01 = 0; goto lEQ2Q; edCJJ: curl_setopt($QHzs0, CURLOPT_URL, $Y4jH4); goto U5ZlF; hOhMI: $MxwHT = curl_exec($QHzs0); goto uT3Te; R3w1V: return FALSE; goto oosfR; QDBSc: ULN7B: goto v7m02; afxLt: MEZZ6: goto fuxER; qjL2o: $IxFts["\163\x63\150\145\x6d\145"] = $htSKi["\x73\x63\150\x65\155\145"]; goto afxLt; Vb0A7: static $vcxNx = 20; goto gNjO2; ml2a7: X0Wus: goto ub2Ta; gNjO2: if (!($Zad01++ >= $vcxNx)) { goto Z510S; } goto H5uKH; H5uKH: $Zad01 = 0; goto R3w1V; fuxER: if ($IxFts["\x68\157\x73\164"]) { goto A0uDu; } goto zYXa_; hdzph: static $Zad01 = 0; goto Vb0A7; zeiL0: if ($IxFts["\x73\x63\150\145\155\145"]) { goto MEZZ6; } goto qjL2o; fOLRr: $UJd13 = curl_getinfo($QHzs0, CURLINFO_HTTP_CODE); goto ZGkmS; v7m02: $Y4jH4 = $IxFts["\163\x63\x68\145\155\145"] . "\x3a\x2f\x2f" . $IxFts["\150\x6f\163\164"] . $IxFts["\160\141\164\150"] . ($IxFts["\161\x75\145\x72\x79"] ? "\x3f" . $IxFts["\161\165\145\x72\x79"] : ''); goto edCJJ; U2S98: return $MxwHT; goto ml2a7; lEQ2Q: return $MxwHT; goto XYXce; ub2Ta: $htSKi = parse_url(curl_getinfo($QHzs0, CURLINFO_EFFECTIVE_URL)); goto zeiL0; Vtsg8: $Zad01 = 0; goto U2S98; EEpDS: A0uDu: goto A8sBo; XtxXs: curl_setopt($QHzs0, CURLOPT_RETURNTRANSFER, true); goto hOhMI; qT26D: $IxFts["\160\x61\164\x68"] = $htSKi["\x70\141\164\150"]; goto QDBSc; zYXa_: $IxFts["\x68\157\x73\164"] = $htSKi["\150\x6f\163\x74"]; goto EEpDS; ekcf5: curl_setopt($QHzs0, CURLOPT_HEADER, true); goto XtxXs; U5ZlF: return $this->curl_redir_exec($QHzs0); goto XSZgu; ew4uL: if ($IxFts) { goto X0Wus; } goto Vtsg8; ERihC: } }