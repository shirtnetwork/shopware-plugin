<?php
/*   __________________________________________________
    |  Obfuscated by YAK Pro - Php Obfuscator  2.0.14  |
    |              on 2023-06-16 11:54:16              |
    |    GitHub: https://github.com/pk-fr/yakpro-po    |
    |__________________________________________________|
*/
 namespace Aggrosoft\Shopware\ShirtnetworkPlugin\Core\Shirtnetwork; use Shopware\Core\Checkout\Order\OrderEntity; use Shopware\Core\Framework\Context; use Shopware\Core\System\SystemConfig\SystemConfigService; use Psr\Cache\CacheItemPoolInterface; class ApiClient { protected $_soapCache = array(); protected $_requestCache = array(); protected $_userIdCache = array(); private $systemConfigService; private $cache; public function __construct(SystemConfigService $AqF0K, CacheItemPoolInterface $C44dg) { $this->systemConfigService = $AqF0K; $this->cache = $C44dg; } public function getUserId(string $xFTih) { goto a217w; O1ZWv: return $y_d4g; goto YhjBl; Vf42X: return $this->_userIdCache[$UqFTk]; goto M4hI0; P0cqO: if (!isset($this->_userIdCache[$UqFTk])) { goto OUYx0; } goto Vf42X; ufPdy: $y_d4g = $this->login($xFTih, $this->systemConfigService->get("\x53\x68\151\x72\x74\x6e\x65\164\x77\x6f\x72\x6b\x50\154\165\147\x69\x6e\56\143\x6f\156\x66\x69\x67\x2e\x75\x73\145\x72\x6e\x61\x6d\145", $xFTih), md5($this->systemConfigService->get("\x53\150\151\x72\164\156\x65\164\167\157\x72\x6b\x50\154\x75\x67\151\156\56\143\x6f\x6e\x66\151\147\56\x70\x61\x73\x73\167\157\x72\x64", $xFTih))); goto cYJ6h; cYJ6h: $this->_userIdCache[$UqFTk] = $y_d4g; goto O1ZWv; a217w: $UqFTk = $xFTih ?: "\144\145\x66\x61\165\x6c\x74"; goto P0cqO; M4hI0: OUYx0: goto ufPdy; YhjBl: } public function login(string $xFTih, $lbvxM, $OqkYT) { goto RxLAp; f7YOw: $Vief8 = $this->SOAPRequest($xFTih, "\125\163\x65\162\x53\x65\162\166\151\x63\145", "\163\x69\x6d\160\154\x65\114\157\147\151\156", $rAeOA, true); goto XLdX6; RxLAp: $rAeOA = array("\x73\125\163\145\162\x4e\x61\155\x65" => $lbvxM, "\x73\x50\x61\163\x73\x77\x6f\162\144" => $OqkYT); goto f7YOw; XLdX6: return $Vief8; goto WyBoN; WyBoN: } public function getProductById(string $xFTih, $iKk8o) { goto m9zbx; wRACy: $sWTN3 = $this->SOAPRequest($xFTih, "\120\x72\x6f\144\x75\x63\164\x53\x65\162\x76\151\x63\145", "\147\145\x74\x42\171\x49\144", $rAeOA, true); goto OnId1; m9zbx: $rAeOA = array("\151\x64" => $iKk8o, "\x62\x6c\x53\x69\155\x70\154\x65" => true); goto wRACy; OnId1: return $sWTN3; goto GOolw; GOolw: } public function getProductPriceScales(string $xFTih, $iKk8o) { goto vDoRr; X8PTF: $Av8mo = $this->SOAPRequest($xFTih, "\120\x72\x69\x63\x65\123\x63\x61\x6c\x65\123\145\x72\x76\151\143\145", "\x67\145\x74\120\x72\157\144\x75\x63\x74\x50\162\151\143\145\123\143\141\x6c\145\x73", $rAeOA, true); goto ciq6m; vDoRr: $sWTN3 = new \stdClass(); goto mL7eH; NJpDI: $rAeOA = array("\x6f\x50\x72\x6f\x64\x75\x63\164" => $sWTN3); goto X8PTF; ciq6m: return $Av8mo->source; goto hYtLy; mL7eH: $sWTN3->id = $iKk8o; goto NJpDI; hYtLy: } public function getVariantById(string $xFTih, $ZhOr9) { goto ecsOA; M9LKk: return $eqYec; goto iOgoA; mBGu9: $eqYec = $this->SOAPRequest($xFTih, "\126\x61\x72\x69\141\x6e\164\123\x65\x72\x76\x69\x63\x65", "\147\x65\164\102\171\x49\144", $rAeOA, true); goto M9LKk; ecsOA: $rAeOA = array("\151\x64" => $ZhOr9); goto mBGu9; iOgoA: } public function getViewsByVariantId(string $xFTih, $ZhOr9) { goto cWpST; cWpST: $eqYec = new \stdClass(); goto nCdx0; nCdx0: $eqYec->id = $ZhOr9; goto iwxTZ; jcNFg: return $kgcPu->source; goto OPETE; zubhl: $kgcPu = $this->SOAPRequest($xFTih, "\126\x61\x72\x69\x61\x6e\164\x56\x69\145\167\123\x65\x72\x76\151\x63\x65", "\x67\145\164\x56\x69\145\167\x73\x42\x79\x56\141\x72\x69\x61\156\x74", $rAeOA, true); goto jcNFg; iwxTZ: $rAeOA = array("\157\126\141\x72\x69\141\x6e\x74" => $eqYec); goto zubhl; OPETE: } public function getViewById(string $xFTih, $A6caM) { goto WiAtU; Cl8NL: $gKgzI = $this->SOAPRequest($xFTih, "\x56\x61\x72\x69\141\x6e\164\x56\151\x65\167\123\145\x72\x76\151\143\145", "\147\145\x74\102\171\111\x64", $rAeOA, true); goto xpa3O; xpa3O: return $gKgzI; goto XIn4k; WiAtU: $rAeOA = array("\x69\x64" => $A6caM); goto Cl8NL; XIn4k: } public function getSizeById(string $xFTih, $OfaMW) { goto y_Qi9; gtoms: $YY2GW = $this->SOAPRequest($xFTih, "\123\151\172\145\123\x65\162\x76\x69\143\x65", "\x67\x65\164\x42\x79\x49\144", $rAeOA, true); goto vM3ml; vM3ml: return $YY2GW; goto veS51; y_Qi9: $rAeOA = array("\151\144" => $OfaMW); goto gtoms; veS51: } public function getSizes(string $xFTih) { goto kjGPB; o86L5: $vofYZ->id = $this->getUserId($xFTih); goto r0R5g; kjGPB: $vofYZ = new \stdClass(); goto o86L5; vuwi0: $yLoAS = $this->SOAPRequest($xFTih, "\123\x69\x7a\145\x53\145\162\166\x69\143\x65", "\x67\x65\x74\125\x73\145\x72", $rAeOA, true); goto bP_5f; bP_5f: return $yLoAS->source; goto y92gt; r0R5g: $rAeOA = array("\x6f\125\163\x65\x72" => $vofYZ); goto vuwi0; y92gt: } public function getPrinttypeById(string $xFTih, $xCXJY) { goto wxxSl; kiHS5: $hT8Jq = $this->SOAPRequest($xFTih, "\x50\162\x69\x6e\x74\164\171\160\145\x53\x65\162\x76\x69\x63\145", "\x67\145\x74\x42\x79\111\x64", $rAeOA, true); goto TN9b4; wxxSl: $rAeOA = array("\x69\144" => $xCXJY); goto kiHS5; TN9b4: return $hT8Jq; goto yZOnp; yZOnp: } public function getPrinttypeColors(string $xFTih, $xCXJY) { goto unPGT; unPGT: $hT8Jq = new \stdClass(); goto rims7; rims7: $hT8Jq->id = $xCXJY; goto lztsQ; lztsQ: $rAeOA = array("\x6f\x50\x72\x69\156\164\x74\171\160\145" => $hT8Jq); goto IW8np; TJJgH: return $fIfQv; goto KKJ8P; IW8np: $fIfQv = $this->SOAPRequest($xFTih, "\x43\157\154\x6f\x72\123\145\x72\166\151\143\x65", "\147\145\164\120\162\151\156\x74\x74\171\160\145\x43\x6f\x6c\x6f\162\x73", $rAeOA, true); goto TJJgH; KKJ8P: } public function getLogoById(string $xFTih = null, $IwInb = null) { goto cpO3F; cpO3F: $rAeOA = array("\x69\144" => $IwInb); goto nwuF5; nwuF5: $h8Jdk = $this->SOAPRequest($xFTih, "\114\x6f\x67\157\123\145\162\x76\x69\x63\145", "\x67\145\164\102\x79\x49\x64", $rAeOA, true); goto Wiojb; Wiojb: return $h8Jdk; goto jnpYL; jnpYL: } public function getLogosByCategory(string $xFTih, $TY3Ic, $JYhsp, $U3tKW) { goto FMK8P; EDC_Y: $tzS_c = new \stdClass(); goto SMrR0; SMrR0: $tzS_c->id = $TY3Ic; goto ni8PR; FMK8P: $vofYZ = new \stdClass(); goto euf1Y; ni8PR: $rAeOA = array("\157\x55\x73\x65\162" => $vofYZ, "\157\103\141\x74\145\147\x6f\x72\171" => $tzS_c, "\151\x4e\165\x6d\x4c\157\x67\157\x73" => $JYhsp, "\151\120\x61\147\x65" => $U3tKW, "\x62\154\116\x6f\x46\154\x61\x73\150" => true); goto Rcom_; Rcom_: $OCINx = $this->SOAPRequest($xFTih, "\114\157\x67\x6f\x53\x65\162\x76\x69\143\x65", "\147\x65\164\125\163\145\162\x53\x65\154\x65\x63\164\145\x64\102\171\103\141\x74\x65\x67\157\162\171", $rAeOA, true); goto E3Yk3; E3Yk3: return $OCINx->source; goto ODExz; euf1Y: $vofYZ->id = $this->getUserId($xFTih); goto EDC_Y; ODExz: } public function getLogosBySearchTerm(string $xFTih, $dJdle, $JYhsp, $U3tKW) { goto FFgb7; bULL3: return $OCINx->source; goto p6o06; FFgb7: $vofYZ = new \stdClass(); goto MQgUE; MQgUE: $vofYZ->id = $this->getUserId($xFTih); goto Td_jS; Td_jS: $rAeOA = array("\x6f\x55\163\145\x72" => $vofYZ, "\163\x53\145\x61\162\x63\x68\x54\145\162\x6d" => $dJdle, "\x69\116\165\155\114\157\x67\157\163" => $JYhsp, "\x69\120\x61\147\x65" => $U3tKW, "\x62\x6c\x4e\157\106\154\x61\163\x68" => true); goto C_2WC; C_2WC: $OCINx = $this->SOAPRequest($xFTih, "\114\157\147\157\123\x65\162\x76\x69\x63\145", "\x67\x65\x74\x55\163\145\x72\123\x65\x6c\x65\143\x74\x65\x64\102\171\123\x65\x61\162\143\x68\124\145\x72\x6d", $rAeOA, true); goto bULL3; p6o06: } public function getLogoCountByCategory(string $xFTih, $TY3Ic) { goto byov5; HsTT8: $IQdzE = $this->SOAPRequest($xFTih, "\x4c\157\147\157\x53\x65\x72\166\151\143\145", "\x67\145\x74\x50\x61\147\145\x43\x6f\165\156\164\106\157\x72\x43\x61\164\145\x67\x6f\162\x79", $rAeOA, true); goto V7JCh; V7JCh: return $IQdzE; goto stbC7; Y91au: $rAeOA = array("\157\125\163\145\162" => $vofYZ, "\157\103\141\164\145\x67\x6f\x72\x79" => $tzS_c, "\x62\x6c\116\x6f\106\154\x61\163\x68" => true); goto HsTT8; CNDtP: $vofYZ->id = $this->getUserId($xFTih); goto aoDXP; aoDXP: $tzS_c = new \stdClass(); goto VmeIV; VmeIV: $tzS_c->id = $TY3Ic; goto Y91au; byov5: $vofYZ = new \stdClass(); goto CNDtP; stbC7: } public function getLogoCountBySearchTerm(string $xFTih, $dJdle) { goto ScolU; vDmpI: $IQdzE = $this->SOAPRequest($xFTih, "\114\157\x67\x6f\x53\145\x72\166\x69\143\145", "\147\x65\164\x50\x61\x67\145\103\x6f\165\156\164\106\157\x72\123\145\x61\162\x63\x68\x54\x65\162\x6d", $rAeOA, true); goto a6KaX; EHEu8: $vofYZ->id = $this->getUserId($xFTih); goto Y8lUj; ScolU: $vofYZ = new \stdClass(); goto EHEu8; a6KaX: return $IQdzE; goto ZuUAP; Y8lUj: $rAeOA = array("\157\x55\x73\x65\162" => $vofYZ, "\x73\123\x65\141\x72\x63\150\x54\x65\162\x6d" => $dJdle, "\x62\154\x4e\157\x46\x6c\x61\163\150" => true); goto vDmpI; ZuUAP: } public function getLogoCategories(string $xFTih) { goto Sg5kr; j8k0g: $rAeOA = array("\x6f\125\x73\145\162" => $vofYZ, "\142\154\116\x6f\x46\x6c\141\x73\150" => true); goto R2SSJ; r7iO5: $vofYZ->id = $this->getUserId($xFTih); goto j8k0g; R2SSJ: $sADxj = $this->SOAPRequest($xFTih, "\x4c\157\x67\157\x43\141\164\145\147\x6f\162\x79\x53\x65\162\166\x69\x63\145", "\x67\x65\x74\x55\x73\145\162\x53\145\154\145\143\x74\x65\x64", $rAeOA, true); goto VpiDq; VpiDq: return $sADxj->source; goto oM1R8; Sg5kr: $vofYZ = new \stdClass(); goto r7iO5; oM1R8: } public function getFirstLogoCategory(string $xFTih) { return $this->getLogoCategories($xFTih)[0]; } public function getCoins(string $xFTih) { goto OhD03; axMNl: $rAeOA = array("\x6f\125\163\x65\162" => $vofYZ); goto YWVhY; OhD03: $vofYZ = new \stdClass(); goto ATOh_; YWVhY: $PmKj3 = $this->SOAPRequest($xFTih, "\125\x73\145\162\123\x65\162\166\151\x63\x65", "\147\x65\164\103\x6f\x69\x6e\x73", $rAeOA, false, true); goto qaS1K; ATOh_: $vofYZ->id = $this->systemConfigService->get("\x53\x68\x69\x72\x74\x6e\145\164\167\157\x72\x6b\x50\154\165\x67\151\156\x2e\x63\x6f\x6e\x66\x69\x67\x2e\x75\x73\x65\162\x69\x64"); goto axMNl; qaS1K: return $PmKj3; goto BZSE9; BZSE9: } public function SOAPRequest($xFTih, $SMLfw, $VsMtD, $shYcl, $C44dg = false, $qhYDa = false) { goto vzV24; fQ7l1: $PKiTJ = $this->cache->getItem($UqFTk); goto QCX4o; T06Pw: h0YSr: goto deT6i; ZS1gM: $this->_soapCache[$UqFTk] = $oGl8G; goto OS1dS; C2Ilh: return $this->_soapCache[$UqFTk]; goto RVUob; SfkPi: $PZDuY->password = $this->systemConfigService->get("\x53\150\151\x72\164\156\145\164\167\x6f\162\x6b\x50\154\x75\x67\151\x6e\x2e\143\x6f\x6e\146\151\x67\56\160\x61\x73\163\x77\x6f\162\144", $xFTih); goto tI3nZ; QCX4o: if (!($C44dg && $PKiTJ->isHit() && $PKiTJ->get())) { goto m61am; } goto Jga9v; PIcYP: try { $oGl8G = call_user_func_array(array($BNqrx, $VsMtD), $shYcl); } catch (\SoapFault $sCbkq) { return null; } goto ZS1gM; oAb1u: HgAFc: goto PIcYP; ZMv2F: if (!$qhYDa) { goto HgAFc; } goto TBdDV; RVUob: fb3hV: goto u2Xch; OS1dS: if (!($C44dg && $oGl8G)) { goto h0YSr; } goto p_Da9; deT6i: return $oGl8G; goto m9R_f; vzV24: $UqFTk = md5("\x73\150\x69\x72\x74\x6e\145\x74\x77\x6f\x72\153\x73\x6f\141\160" . $SMLfw . $VsMtD . serialize($shYcl)); goto fQ7l1; GVOUc: $BNqrx->__setSoapHeaders(array($yQvgf)); goto oAb1u; cXoHj: $PZDuY->username = $this->systemConfigService->get("\x53\150\151\x72\164\x6e\x65\x74\x77\157\162\153\x50\x6c\x75\x67\151\156\56\x63\x6f\156\146\x69\x67\x2e\165\x73\x65\x72\x6e\x61\155\145", $xFTih); goto SfkPi; QESG8: m61am: goto vfez2; u2Xch: $BNqrx = new \SoapClient("\x68\x74\164\x70\72\x2f\x2f\x61\x70\x69\x2e\x73\150\x69\x72\x74\x6e\145\164\x77\157\162\153\x2e\x64\x65\57\x73\x6f\141\160\x2f\x3f\163\x65\x72\166\x69\143\145\75{$SMLfw}\x26\167\163\144\x6c\75\x31"); goto ZMv2F; TBdDV: $PZDuY = new \stdClass(); goto cXoHj; Jga9v: return $PKiTJ->get(); goto QESG8; vfez2: if (!isset($this->_soapCache[$UqFTk])) { goto fb3hV; } goto C2Ilh; tI3nZ: $yQvgf = new \SoapHeader("\150\164\164\x70\x3a\57\x2f\x61\160\151\56\163\x68\x69\x72\x74\156\145\164\x77\x6f\162\x6b\56\144\x65\x2f\x73\x6f\x61\160\57\x3f\x73\145\x72\166\151\143\145\x3d" . $SMLfw, "\x61\165\x74\150\145\156\x74\x69\143\141\164\x65", $PZDuY); goto GVOUc; S8HD2: $this->cache->save($PKiTJ); goto T06Pw; p_Da9: $PKiTJ->set($oGl8G); goto S8HD2; m9R_f: } public function getConfig(string $xFTih, $YzZ9O) { goto rdt3Z; EV8Ka: $PKiTJ = $this->cache->getItem($UqFTk); goto r8WvD; rYL9I: return json_decode(unserialize($PKiTJ->get())); goto CkqtB; pYzzH: $m2eES = $this->GETRequest($xilvj); goto YwGRX; r8WvD: if (!($PKiTJ->isHit() && $PKiTJ->get())) { goto m3bgB; } goto rYL9I; r41dj: $this->cache->save($PKiTJ); goto UIu3R; CkqtB: m3bgB: goto rLXW9; rLXW9: $xilvj = $this->systemConfigService->get("\x53\150\x69\162\x74\x6e\145\x74\167\x6f\162\153\120\154\x75\147\x69\156\x2e\143\157\x6e\x66\151\x67\56\143\x6f\156\146\x69\x67\x73\x65\x72\166\145\x72", $xFTih); goto r3dwj; YwGRX: $PKiTJ->set(serialize($m2eES)); goto r41dj; UIu3R: return json_decode($m2eES); goto kn6YD; r3dwj: $xilvj .= "\x2f\143\157\x6e\146\151\x67\x2f" . $YzZ9O; goto pYzzH; rdt3Z: $UqFTk = md5("\x73\150\x69\162\164\x6e\x65\164\167\157\162\x6b\x63\157\x6e\146\x69\x67" . $YzZ9O); goto EV8Ka; kn6YD: } public function getConfigServerUrl(string $xFTih) { return $this->systemConfigService->get("\x53\150\x69\x72\x74\x6e\x65\x74\167\x6f\x72\x6b\120\154\x75\147\x69\x6e\x2e\143\x6f\156\x66\x69\x67\56\143\157\x6e\x66\x69\147\x73\145\x72\166\x65\162", $xFTih); } public function getSOAPUserObject(string $xFTih) { return array("\151\x64" => $this->getUserId($xFTih)); } public function getRest($Hrn4h) { return json_decode($this->GETRequest("\x68\164\164\160\72\57\x2f\x61\x70\151\x2e\163\x68\x69\162\164\x6e\x65\164\x77\x6f\x72\x6b\56\x64\x65\x2f\162\145\x73\164\x2f" . $Hrn4h)); } public function GETRequest($eevwH) { goto nPU9V; NIlKk: $this->_requestCache[$UqFTk] = $QljHW; goto Hee8w; OBPZu: if (!isset($this->_requestCache[$UqFTk])) { goto z4tMu; } goto B9nzv; MEgfZ: curl_setopt($QQD7Y, CURLOPT_URL, $eevwH); goto DGVpu; Hee8w: return $QljHW; goto UD25i; QnhTu: z4tMu: goto PgyNe; DGVpu: curl_setopt($QQD7Y, CURLOPT_POST, 0); goto b_FHk; B9nzv: return $this->_requestCache[$UqFTk]; goto QnhTu; kBnTd: $QljHW = trim($QljHW); goto NIlKk; PgyNe: $QQD7Y = curl_init(); goto MEgfZ; b_FHk: curl_setopt($QQD7Y, CURLOPT_RETURNTRANSFER, 1); goto LIdXP; LIdXP: $QljHW = curl_exec($QQD7Y); goto d2x6S; nPU9V: $UqFTk = md5($eevwH); goto OBPZu; d2x6S: curl_close($QQD7Y); goto kBnTd; UD25i: } public function POSTRequest($eevwH, $gVRu7) { goto hF1s2; JnzZI: curl_setopt($QQD7Y, CURLOPT_URL, $eevwH); goto zbftX; YARe5: $QljHW = trim($QljHW); goto D5Nek; zbftX: curl_setopt($QQD7Y, CURLOPT_POST, 1); goto m_0m5; fRORR: curl_setopt($QQD7Y, CURLOPT_POSTFIELDS, http_build_query($gVRu7)); goto iMl6D; mtLr0: curl_close($QQD7Y); goto YARe5; D5Nek: return $QljHW; goto O39pB; m_0m5: curl_setopt($QQD7Y, CURLOPT_RETURNTRANSFER, 1); goto fRORR; hF1s2: $QQD7Y = curl_init(); goto JnzZI; iMl6D: $QljHW = curl_exec($QQD7Y); goto mtLr0; O39pB: } public function getAssetUrl(string $xFTih, $XNmdS, $FmIUV) { $xpkg9 = $this->getUserId($xFTih); return "\150\x74\164\x70\163\72\x2f\x2f\141\160\x69\56\x73\x68\x69\x72\164\x6e\x65\164\167\x6f\162\153\x2e\144\145\57\x6f\x75\x74\57" . $XNmdS . "\x2f" . $xpkg9 . "\x2f" . $FmIUV; } public function bookCoins(string $xFTih, $XPx8Z, $AkKK2, $bCM3f = 0, $P5CEY = 0) { goto HgeNm; WmuaE: curl_close($QQD7Y); goto c9Tba; lLpYh: $p5r5S = "\x68\164\x74\160\x3a\57\x2f\141\160\x69\x2e\163\x68\151\162\x74\156\x65\164\x77\x6f\162\153\x2e\144\x65\57\163\x68\151\162\164\x6e\145\164\167\157\162\x6b\57\142\157\157\153\x2e\152\x73\160"; goto j8wCP; L8e0A: $QljHW = curl_exec($QQD7Y); goto WmuaE; wuO1F: $this->bookLog($XPx8Z, $AkKK2, $QljHW, $P5CEY); goto aQcqn; C_onb: curl_setopt($QQD7Y, CURLOPT_RETURNTRANSFER, 1); goto z0iHP; aQcqn: return trim($QljHW); goto SjrMN; HgeNm: $ceG65 = $this->systemConfigService->get("\x53\150\x69\x72\x74\x6e\145\x74\x77\x6f\162\153\x50\x6c\165\147\x69\x6e\x2e\143\x6f\x6e\x66\151\147\x2e\165\163\145\x72\x6e\141\155\x65", $xFTih); goto rsMA6; rsMA6: $Mt2aV = $this->systemConfigService->get("\x53\150\x69\162\x74\156\145\x74\x77\157\x72\x6b\x50\154\x75\x67\x69\156\x2e\x63\x6f\156\x66\x69\x67\56\x70\141\163\163\x77\x6f\x72\144", $xFTih); goto qlzo6; j8wCP: curl_setopt($QQD7Y, CURLOPT_URL, $p5r5S); goto SOwx_; qlzo6: $QQD7Y = curl_init(); goto lLpYh; c9Tba: $QljHW = trim($QljHW); goto wuO1F; SOwx_: curl_setopt($QQD7Y, CURLOPT_POST, 1); goto C_onb; z0iHP: curl_setopt($QQD7Y, CURLOPT_POSTFIELDS, "\165\163\145\162\156\x61\x6d\145\x3d" . $ceG65 . "\46\160\x61\x73\x73\x77\157\x72\144\75" . md5($Mt2aV) . "\46\x71\x75\x61\156\164\151\x74\171\75" . $XPx8Z . "\x26\153\x65\x79\x3d" . $AkKK2 . "\46\141\x66\x66\151\154\141\x74\x65\75" . $bCM3f . "\46\x70\x72\157\x76\151\163\x69\157\x6e\x3d" . $P5CEY); goto L8e0A; SjrMN: } public function bookLog($XyV5d, $AkKK2, $oGl8G, $P5CEY) { goto PlfXf; nkK6X: $DnOG9 .= "\x5b" . date("\155\x2f\144\x2f\131\40\x67\x3a\151\x20\x41") . "\x5d\x20\x2d\x20" . "\102\157\x6f\x6b\x69\156\x67\40\x72\145\163\165\x6c\x74\x3a\40{$oGl8G}" . "\xa"; goto D0mCh; mFw7D: $DnOG9 .= "\x2a\52\52\x2a\52\x2a\52\52\52\52\52\x2a\52\52\x2a\x2a\52\x2a\x2a\52\52\52\52\52\x2a\52\52\x2a\x2a\x2a\x2a\x2a\52\x2a\52\52\52\52\x2a\x2a\x2a\x2a\x2a" . "\xa"; goto poj6e; D0mCh: $DnOG9 .= "\121\x75\x61\x6e\x74\151\x74\171\72\x20{$XyV5d}\x2c\x20\117\162\x64\145\x72\x6b\x65\171\72\40{$AkKK2}\54\x20\x50\x72\x6f\x76\151\x73\151\157\x6e\72\40{$P5CEY}\xa"; goto mFw7D; PlfXf: $DnOG9 = "\43\x23\x23\x23\43\43\43\43\x23\x23\x23\43\43\43\x23\x23\x23\43\43\x23\x23\x23\x23\43\43\43\x23\43\x23\x23\43\x23\x23\x23\43\x23\x23\x23\43\43\x23\43\x23" . "\12"; goto nkK6X; poj6e: } public function manifestOrder(string $xFTih, $rdQx0) { goto DPMZ5; kjoHU: $xilvj = $this->systemConfigService->get("\123\150\x69\162\x74\x6e\145\164\167\157\x72\153\120\x6c\x75\x67\151\x6e\x2e\x63\x6f\156\x66\x69\x67\56\143\x6f\156\146\151\147\x73\145\x72\166\145\x72", $xFTih); goto cW1Hv; cW1Hv: $xilvj .= "\57\x6f\162\x64\145\x72"; goto BMeGY; ie9hW: $DCc3q = $rdQx0->getOrderCustomer(); goto SAh6e; SAh6e: $wGh_x = ["\x6f\162\144\145\162\137\151\x64" => $rdQx0->getOrderNumber(), "\x6f\x72\144\x65\162\137\144\141\164\145" => $rdQx0->getOrderDateTime()->format("\x59\x2d\x6d\x2d\x64\40\110\x3a\151\x3a\x73"), "\x63\x75\x73\164\x6f\x6d\145\x72\x5f\156\x61\x6d\145" => $DCc3q->getFirstName() . "\40" . $DCc3q->getLastName(), "\x63\x6f\x6e\146\x69\x67\163" => $t9NxA, "\x61\x6d\x6f\165\156\x74\x73" => $dad4u]; goto kjoHU; CIGRb: MBAh6: goto ie9hW; BMeGY: $this->POSTRequest($xilvj, $wGh_x); goto UjPYi; DPMZ5: $X3CyD = $rdQx0->getLineItems(); goto qNHKM; qNHKM: $t9NxA = []; goto zidNr; Fgt2Q: foreach ($X3CyD as $k0hsl) { goto P2P9O; bQyPc: $t9NxA[] = $JppnX["\163\x68\x69\162\x74\156\x65\164\x77\157\162\x6b"]; goto gGM16; U3A4e: if (!isset($JppnX["\x73\150\x69\162\x74\156\x65\164\167\157\x72\153"])) { goto DrRrb; } goto bQyPc; ZyNst: $YzZ9O = $this->getConfig($xFTih, $JppnX["\163\x68\151\162\x74\x6e\x65\x74\167\x6f\x72\153"]); goto YYyq7; Fnu7V: peobx: goto yWMXc; yWMXc: DrRrb: goto EpFNO; YYyq7: foreach ($YzZ9O->objects as $sKNPQ) { goto aXCh9; X5XwF: $this->manifestUpload($xFTih, $mUDZN); goto E7Hki; ETgA3: QiR2E: goto Mn_h1; E7Hki: BoWCL: goto ETgA3; Ky1ic: $kjQY9 = explode("\57", $sKNPQ->meta->original); goto aZbEO; aZbEO: $mUDZN = array_pop($kjQY9); goto X5XwF; aXCh9: if (!($sKNPQ->type === "\165\x73\145\162\x2d\x6c\157\x67\x6f")) { goto BoWCL; } goto Ky1ic; Mn_h1: } goto Fnu7V; gGM16: $dad4u[] = $k0hsl->getQuantity(); goto ZyNst; P2P9O: $JppnX = $k0hsl->getPayload(); goto U3A4e; EpFNO: SyS9O: goto CqTJT; CqTJT: } goto CIGRb; zidNr: $dad4u = []; goto Fgt2Q; UjPYi: } public function getResourceLink(string $xFTih, $XNmdS, $kjQY9) { goto K0vFw; lQ1w_: $qhEqR .= "\x2f\157\x75\164\x2f"; goto uQ1Tm; uQ1Tm: $qhEqR .= "{$XNmdS}\57"; goto aoFlw; aoFlw: $qhEqR .= $this->getUserId($xFTih) . "\x2f"; goto RrrSu; RrrSu: $qhEqR .= $kjQY9; goto XyLK3; XyLK3: return $qhEqR; goto jpvXN; K0vFw: $qhEqR = "\x68\164\164\160\72\57\57\x61\x70\151\x2e\x73\150\151\162\164\156\145\164\x77\x6f\162\153\x2e\x64\x65"; goto lQ1w_; jpvXN: } public function manifestUpload(string $xFTih, $oqXmR) { goto LTVMq; gKhTa: $zyi5M = $this->GETRequest($xilvj); goto oK8lA; LTVMq: $xilvj = str_replace("\57\146\151\x6c\145\163", '', $this->systemConfigService->get("\123\x68\151\162\x74\156\145\x74\167\x6f\x72\153\120\154\x75\147\151\156\56\143\157\x6e\146\x69\147\x2e\165\x70\x6c\x6f\141\144\x73\145\162\166\145\162", $xFTih)); goto UP_z2; UP_z2: $xilvj .= "\57\155\141\x6e\151\146\x65\163\x74\57" . $oqXmR; goto gKhTa; oK8lA: } public function currencyConvert($I_ToI, $lZrP7, $hroQv = 0) { goto TM94C; TM94C: $eevwH = str_replace("\x7b\x7b\x43\x55\122\x52\x45\x4e\x43\x59\137\x46\122\117\x4d\175\175", $I_ToI, "\x68\164\x74\160\72\57\x2f\161\165\157\164\145\x2e\x79\141\150\157\x6f\x2e\x63\157\155\x2f\x64\x2f\x71\165\157\164\x65\x73\56\143\x73\x76\77\163\75\173\x7b\x43\125\x52\122\x45\116\x43\131\x5f\x46\122\x4f\115\175\175\x7b\173\x43\125\x52\122\105\116\103\131\x5f\x54\x4f\x7d\x7d\75\x58\x26\146\x3d\154\61\46\145\75\56\143\163\166"); goto jYaEz; jYaEz: $eevwH = str_replace("\x7b\x7b\x43\x55\122\x52\105\116\x43\x59\x5f\124\x4f\x7d\x7d", $lZrP7, $eevwH); goto cqW9S; cqW9S: try { goto eL1ye; ZNYSu: return (float) $ecf0Q * 1.0; goto PVI9z; m2CkG: if ($ecf0Q) { goto HZuU_; } goto IGW8j; eL1ye: $ecf0Q = $this->redir_curl($eevwH); goto m2CkG; IGW8j: return null; goto RRkFn; RRkFn: HZuU_: goto ZNYSu; PVI9z: } catch (Exception $u3MTu) { goto i_0_u; EPpZR: return $this->currencyConvert($I_ToI, $lZrP7, 1); goto srwd1; i_0_u: if (!($hroQv == 0)) { goto AQUoa; } goto EPpZR; srwd1: AQUoa: goto M1eRB; M1eRB: } goto Ef9Ub; Ef9Ub: } private function redir_curl($eevwH) { goto eporF; maNgJ: NuXAO: goto hmNgX; n6VRp: curl_setopt($YhhqR, CURLOPT_FOLLOWLOCATION, RH80A); goto ho5yN; HIA60: return $E9qpZ; goto OryoI; ir8bS: if (ini_get("\x6f\160\145\156\137\x62\x61\163\145\x64\x69\162") == '' && ini_get("\163\x61\146\x65\137\x6d\x6f\144\x65" == "\x4f\x66\146")) { goto SoTnT; } goto Wopl1; Hb4K9: goto NuXAO; goto POnv7; POnv7: SoTnT: goto n6VRp; ho5yN: $E9qpZ = curl_exec($YhhqR); goto maNgJ; Wopl1: $E9qpZ = $this->curl_redir_exec($YhhqR); goto Hb4K9; eporF: $YhhqR = curl_init($eevwH); goto t3jGi; hmNgX: curl_close($YhhqR); goto HIA60; t3jGi: curl_setopt($YhhqR, CURLOPT_URL, $eevwH); goto ir8bS; OryoI: } private function curl_redir_exec($QQD7Y) { goto iNvgu; FXopH: list($pZ78A, $sesXy) = explode("\12\xd", $sesXy, 2); goto bESMS; Gp74t: $TTtT0 = 0; goto dk9Qh; zUrZP: return $sesXy; goto BXb03; U2h1n: if ($eevwH) { goto GIgP1; } goto iQUYi; CyBTw: GIgP1: goto YEkDD; rbs1c: TbZB1: goto fkkZc; zQ2UM: oI2DO: goto cWIMq; nVc2j: $eevwH["\163\143\x68\x65\x6d\145"] = $TF7G7["\163\x63\150\145\x6d\145"]; goto Vg2MA; gAC4s: preg_match("\57\x4c\x6f\x63\x61\164\151\157\156\72\x28\x2e\x2a\x3f\x29\134\156\x2f", $pZ78A, $dJEev); goto iawDF; TGtvo: if (!($TTtT0++ >= $qhX7R)) { goto aryew; } goto Gp74t; x9OBv: PeKrZ: goto gatw3; iawDF: $eevwH = @parse_url(trim(array_pop($dJEev))); goto U2h1n; c4R3j: static $qhX7R = 20; goto TGtvo; na_oP: curl_setopt($QQD7Y, CURLOPT_HEADER, true); goto Y1NCr; FxnH1: if ($eevwH["\x68\157\x73\164"]) { goto TbZB1; } goto EQh9m; gatw3: $dJEev = array(); goto gAC4s; UdoX4: aryew: goto na_oP; bESMS: $sxjNC = curl_getinfo($QQD7Y, CURLINFO_HTTP_CODE); goto W8j3b; iNvgu: static $TTtT0 = 0; goto c4R3j; C6Uyq: $sesXy = curl_exec($QQD7Y); goto FXopH; dekoO: $TTtT0 = 0; goto zUrZP; KNCgn: return $sesXy; goto CyBTw; fkkZc: if ($eevwH["\x70\x61\164\x68"]) { goto N9Tea; } goto vvx54; W8j3b: if ($sxjNC == 301 || $sxjNC == 302) { goto PeKrZ; } goto dekoO; BXb03: goto oI2DO; goto x9OBv; IVnF6: $ZqFPP = $eevwH["\x73\143\x68\x65\155\145"] . "\72\57\57" . $eevwH["\150\x6f\163\164"] . $eevwH["\x70\x61\x74\150"] . ($eevwH["\161\x75\x65\x72\x79"] ? "\77" . $eevwH["\161\x75\145\x72\171"] : ''); goto WplNc; dk9Qh: return FALSE; goto UdoX4; Vg2MA: C07ks: goto FxnH1; YEkDD: $TF7G7 = parse_url(curl_getinfo($QQD7Y, CURLINFO_EFFECTIVE_URL)); goto zBj_c; iQUYi: $TTtT0 = 0; goto KNCgn; VPE7m: N9Tea: goto IVnF6; zBj_c: if ($eevwH["\163\143\150\145\x6d\145"]) { goto C07ks; } goto nVc2j; vvx54: $eevwH["\x70\141\164\x68"] = $TF7G7["\160\x61\x74\150"]; goto VPE7m; Y1NCr: curl_setopt($QQD7Y, CURLOPT_RETURNTRANSFER, true); goto C6Uyq; EQh9m: $eevwH["\150\x6f\163\164"] = $TF7G7["\150\x6f\163\164"]; goto rbs1c; WplNc: curl_setopt($QQD7Y, CURLOPT_URL, $ZqFPP); goto LGZTl; LGZTl: return $this->curl_redir_exec($QQD7Y); goto zQ2UM; cWIMq: } }