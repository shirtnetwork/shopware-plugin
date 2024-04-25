<?php
/*   __________________________________________________
    |  Obfuscated by YAK Pro - Php Obfuscator  2.0.14  |
    |              on 2024-04-25 09:39:54              |
    |    GitHub: https://github.com/pk-fr/yakpro-po    |
    |__________________________________________________|
*/
 namespace Aggrosoft\Shopware\ShirtnetworkPlugin\Core\Shirtnetwork; use Shopware\Core\Checkout\Order\OrderEntity; use Shopware\Core\Framework\Context; use Shopware\Core\System\SystemConfig\SystemConfigService; use Psr\Cache\CacheItemPoolInterface; class ApiClient { protected $_soapCache = array(); protected $_requestCache = array(); protected $_userIdCache = array(); private $systemConfigService; private $cache; public function __construct(SystemConfigService $Z9n9R, CacheItemPoolInterface $ZwMRX) { $this->systemConfigService = $Z9n9R; $this->cache = $ZwMRX; } public function getUserId(string $qf1h6) { goto cph3T; Rnczn: $this->_userIdCache[$z7xMq] = $C5RjQ; goto nQV7D; nQV7D: return $C5RjQ; goto XVqWG; cph3T: $z7xMq = $qf1h6 ?: "\x64\145\146\141\x75\x6c\x74"; goto zfpjF; uREFd: puq0L: goto WEGgT; WEGgT: $C5RjQ = $this->login($qf1h6, $this->systemConfigService->get("\x53\x68\151\x72\x74\x6e\x65\164\x77\x6f\162\x6b\x50\x6c\x75\147\151\156\56\x63\157\156\x66\x69\x67\56\165\163\145\x72\156\141\x6d\145", $qf1h6), md5($this->systemConfigService->get("\x53\x68\x69\x72\x74\x6e\145\164\167\157\162\153\x50\154\x75\147\x69\156\56\143\x6f\156\146\151\147\x2e\x70\141\163\163\167\x6f\162\x64", $qf1h6))); goto Rnczn; Ip9ls: return $this->_userIdCache[$z7xMq]; goto uREFd; zfpjF: if (!isset($this->_userIdCache[$z7xMq])) { goto puq0L; } goto Ip9ls; XVqWG: } public function login(string $qf1h6, $e2s84, $VKonJ) { goto ZBuw1; ZBuw1: $xoHba = array("\x73\x55\163\145\162\116\x61\x6d\145" => $e2s84, "\163\120\141\x73\163\x77\157\162\144" => $VKonJ); goto uv5Vu; uv5Vu: $xGB3g = $this->SOAPRequest($qf1h6, "\x55\163\145\x72\123\x65\x72\x76\151\143\x65", "\x73\x69\155\x70\154\145\114\x6f\147\151\156", $xoHba, true); goto hes_W; hes_W: return $xGB3g; goto v3OxR; v3OxR: } public function getProductById(string $qf1h6, $uhUx1) { goto xghNS; rYvW9: $KJ8jW = $this->SOAPRequest($qf1h6, "\120\162\x6f\x64\165\x63\x74\123\145\162\166\151\x63\145", "\x67\145\164\102\171\111\144", $xoHba, true); goto DmX76; DmX76: return $KJ8jW; goto XMUqe; xghNS: $xoHba = array("\151\x64" => $uhUx1, "\x62\x6c\x53\x69\x6d\x70\154\145" => true); goto rYvW9; XMUqe: } public function getProductPriceScales(string $qf1h6, $uhUx1) { goto NVUEL; NVUEL: $KJ8jW = new \stdClass(); goto f7klD; f7klD: $KJ8jW->id = $uhUx1; goto qOZF6; UUmXH: $Yeftk = $this->SOAPRequest($qf1h6, "\x50\162\x69\x63\145\123\143\x61\x6c\145\x53\x65\162\x76\151\143\145", "\147\145\164\x50\162\x6f\144\x75\143\x74\x50\162\151\x63\145\x53\143\x61\154\x65\163", $xoHba, true); goto MD9Vm; qOZF6: $xoHba = array("\157\x50\162\157\144\165\x63\164" => $KJ8jW); goto UUmXH; MD9Vm: return $Yeftk->source; goto RYffh; RYffh: } public function getVariantById(string $qf1h6, $M3MDb) { goto QCMzy; QCMzy: $xoHba = array("\151\x64" => $M3MDb); goto ZzXSU; Q316N: return $pApvp; goto PeT_c; ZzXSU: $pApvp = $this->SOAPRequest($qf1h6, "\126\x61\x72\x69\141\156\x74\x53\x65\162\166\x69\143\145", "\x67\145\164\x42\x79\x49\144", $xoHba, true); goto Q316N; PeT_c: } public function getViewsByVariantId(string $qf1h6, $M3MDb) { goto ImJLT; jRiLg: $xoHba = array("\157\126\x61\162\151\141\x6e\x74" => $pApvp); goto rYVZZ; scVed: $pApvp->id = $M3MDb; goto jRiLg; ImJLT: $pApvp = new \stdClass(); goto scVed; rYVZZ: $NLDco = $this->SOAPRequest($qf1h6, "\126\x61\162\151\141\156\x74\x56\151\145\167\x53\x65\162\x76\151\143\x65", "\147\145\164\x56\x69\x65\x77\163\102\171\126\x61\162\151\141\x6e\164", $xoHba, true); goto DEP64; DEP64: return $NLDco->source; goto FnxqA; FnxqA: } public function getViewById(string $qf1h6, $oR9o0) { goto jqFFQ; NnsqW: return $z5wVD; goto g2Op2; jqFFQ: $xoHba = array("\x69\x64" => $oR9o0); goto sOsp2; sOsp2: $z5wVD = $this->SOAPRequest($qf1h6, "\126\141\162\x69\x61\156\x74\x56\151\x65\x77\123\145\162\x76\151\x63\145", "\x67\145\x74\102\171\x49\x64", $xoHba, true); goto NnsqW; g2Op2: } public function getSizeById(string $qf1h6, $sFX1H) { goto HnAre; HnAre: $xoHba = array("\151\x64" => $sFX1H); goto j73Dt; j73Dt: $ww70I = $this->SOAPRequest($qf1h6, "\123\x69\x7a\145\123\145\x72\x76\151\143\145", "\x67\x65\164\102\171\111\144", $xoHba, true); goto x1bnW; x1bnW: return $ww70I; goto N0qYa; N0qYa: } public function getSizes(string $qf1h6) { goto hjHzL; VtchI: $xoHba = array("\x6f\125\163\x65\x72" => $rmth3); goto exyot; exyot: $xlwyJ = $this->SOAPRequest($qf1h6, "\x53\x69\172\145\x53\x65\x72\166\151\x63\145", "\147\145\164\x55\163\x65\x72", $xoHba, true); goto POBgY; hjHzL: $rmth3 = new \stdClass(); goto V4DjJ; POBgY: return $xlwyJ->source; goto JhEPq; V4DjJ: $rmth3->id = $this->getUserId($qf1h6); goto VtchI; JhEPq: } public function getPrinttypeById(string $qf1h6, $sGHQg) { goto N8kSe; N8kSe: $xoHba = array("\x69\x64" => $sGHQg); goto ojUJb; ojUJb: $oEHN2 = $this->SOAPRequest($qf1h6, "\120\162\x69\156\x74\x74\x79\160\145\123\145\x72\166\151\x63\x65", "\147\x65\x74\x42\x79\111\x64", $xoHba, true); goto eDUAK; eDUAK: return $oEHN2; goto a2jLK; a2jLK: } public function getPrinttypeColors(string $qf1h6, $sGHQg) { goto AAzXJ; u5qPL: return $tRX1w; goto XeILq; n25yE: $oEHN2->id = $sGHQg; goto hbJKS; hbJKS: $xoHba = array("\157\120\162\151\x6e\x74\164\171\160\145" => $oEHN2); goto oni7s; oni7s: $tRX1w = $this->SOAPRequest($qf1h6, "\x43\x6f\x6c\157\x72\123\x65\162\x76\x69\143\145", "\147\x65\x74\120\x72\x69\x6e\x74\164\x79\x70\x65\103\157\x6c\157\162\163", $xoHba, true); goto u5qPL; AAzXJ: $oEHN2 = new \stdClass(); goto n25yE; XeILq: } public function getLogoById(string $qf1h6 = null, $jqBny = null) { goto wHhXK; yQZxk: return $PPv0I; goto M5bfd; baupt: $PPv0I = $this->SOAPRequest($qf1h6, "\114\x6f\147\157\x53\145\x72\x76\151\x63\x65", "\x67\145\x74\x42\171\111\144", $xoHba, true); goto yQZxk; wHhXK: $xoHba = array("\151\x64" => $jqBny); goto baupt; M5bfd: } public function getLogosByCategory(string $qf1h6, $C7K87, $daJy9, $YuKNb) { goto v6p00; XYjxa: $TkXgF = $this->SOAPRequest($qf1h6, "\114\157\147\x6f\x53\145\x72\x76\x69\x63\x65", "\147\x65\x74\125\x73\145\x72\123\x65\x6c\x65\x63\x74\145\x64\x42\x79\x43\141\x74\145\x67\157\x72\x79", $xoHba, true); goto c5Iyt; c5Iyt: return $TkXgF->source; goto Gz5_O; q8Fzo: $rmth3->id = $this->getUserId($qf1h6); goto AywQq; AywQq: $I2aru = new \stdClass(); goto iCOxP; v6p00: $rmth3 = new \stdClass(); goto q8Fzo; iCOxP: $I2aru->id = $C7K87; goto xGleH; xGleH: $xoHba = array("\157\x55\163\145\x72" => $rmth3, "\x6f\x43\141\x74\145\x67\157\x72\171" => $I2aru, "\x69\116\x75\x6d\x4c\157\147\157\x73" => $daJy9, "\x69\x50\141\x67\x65" => $YuKNb, "\142\x6c\x4e\x6f\106\x6c\141\x73\150" => true); goto XYjxa; Gz5_O: } public function getLogosBySearchTerm(string $qf1h6, $bGXLV, $daJy9, $YuKNb) { goto ih6bI; ih6bI: $rmth3 = new \stdClass(); goto PRtXH; PRtXH: $rmth3->id = $this->getUserId($qf1h6); goto u57qc; u57qc: $xoHba = array("\157\125\x73\x65\x72" => $rmth3, "\163\x53\145\x61\162\143\150\x54\145\x72\155" => $bGXLV, "\x69\116\x75\155\114\x6f\147\157\x73" => $daJy9, "\x69\x50\x61\147\145" => $YuKNb, "\x62\154\116\157\x46\154\141\x73\150" => true); goto DMHZE; wCwje: return $TkXgF->source; goto M7uDa; DMHZE: $TkXgF = $this->SOAPRequest($qf1h6, "\x4c\157\x67\x6f\x53\145\162\166\x69\x63\145", "\x67\x65\x74\125\x73\145\162\x53\x65\154\x65\x63\164\145\x64\102\x79\x53\x65\x61\162\143\150\x54\x65\162\x6d", $xoHba, true); goto wCwje; M7uDa: } public function getLogoCountByCategory(string $qf1h6, $C7K87) { goto kjQty; kjQty: $rmth3 = new \stdClass(); goto hSTE4; Tagaa: $nc2mL = $this->SOAPRequest($qf1h6, "\114\x6f\x67\x6f\x53\145\x72\x76\x69\143\145", "\x67\145\164\120\141\x67\145\103\x6f\x75\156\164\x46\x6f\x72\x43\x61\x74\145\x67\157\162\171", $xoHba, true); goto hd2rS; hSTE4: $rmth3->id = $this->getUserId($qf1h6); goto FOs3I; hd2rS: return $nc2mL; goto NZK2k; FOs3I: $I2aru = new \stdClass(); goto uVQ0f; x9fPK: $xoHba = array("\157\x55\x73\x65\162" => $rmth3, "\x6f\x43\141\x74\x65\147\x6f\162\x79" => $I2aru, "\x62\154\x4e\x6f\106\x6c\141\163\150" => true); goto Tagaa; uVQ0f: $I2aru->id = $C7K87; goto x9fPK; NZK2k: } public function getLogoCountBySearchTerm(string $qf1h6, $bGXLV) { goto Wxsdg; Wxsdg: $rmth3 = new \stdClass(); goto zyuTp; lS3Gm: return $nc2mL; goto e1Llo; FvftT: $nc2mL = $this->SOAPRequest($qf1h6, "\114\157\x67\157\123\145\162\166\x69\143\145", "\147\x65\164\120\x61\x67\145\103\157\x75\x6e\164\x46\157\x72\123\145\x61\x72\143\x68\124\x65\x72\155", $xoHba, true); goto lS3Gm; m0o7L: $xoHba = array("\157\x55\163\145\162" => $rmth3, "\x73\x53\x65\x61\x72\143\150\x54\145\162\155" => $bGXLV, "\x62\154\116\157\106\154\x61\x73\x68" => true); goto FvftT; zyuTp: $rmth3->id = $this->getUserId($qf1h6); goto m0o7L; e1Llo: } public function getLogoCategories(string $qf1h6) { goto LoBzx; LoBzx: $rmth3 = new \stdClass(); goto arb8J; tGa3P: return $jW8zC->source; goto hb2fm; zt0Y1: $jW8zC = $this->SOAPRequest($qf1h6, "\x4c\157\x67\157\103\x61\164\145\147\157\162\171\x53\x65\162\166\x69\x63\145", "\147\x65\x74\x55\x73\145\x72\x53\145\x6c\x65\x63\x74\145\144", $xoHba, true); goto tGa3P; tA78J: $xoHba = array("\157\125\163\x65\x72" => $rmth3, "\x62\154\x4e\x6f\106\154\141\163\150" => true); goto zt0Y1; arb8J: $rmth3->id = $this->getUserId($qf1h6); goto tA78J; hb2fm: } public function getFirstLogoCategory(string $qf1h6) { return $this->getLogoCategories($qf1h6)[0]; } public function getCoins(string $qf1h6) { goto wI7oc; drvrt: return $QU05V; goto zeFMT; SdBBf: $xoHba = array("\157\x55\x73\x65\162" => $rmth3); goto TpAEV; TpAEV: $QU05V = $this->SOAPRequest($qf1h6, "\x55\x73\x65\162\x53\x65\x72\x76\x69\143\145", "\147\145\164\x43\157\151\156\x73", $xoHba, false, true); goto drvrt; wI7oc: $rmth3 = new \stdClass(); goto x6zE1; x6zE1: $rmth3->id = $this->systemConfigService->get("\123\x68\151\x72\x74\x6e\x65\164\x77\x6f\x72\x6b\120\x6c\x75\147\x69\x6e\56\x63\x6f\156\146\151\x67\56\x75\x73\x65\x72\x69\144"); goto SdBBf; zeFMT: } public function SOAPRequest($qf1h6, $n2iWi, $JMqvs, $QHoiK, $ZwMRX = false, $ftrR2 = false) { goto G97wH; JvWt1: $rjrBe = new \SoapClient("\150\x74\x74\160\72\57\57\x61\x70\151\56\163\x68\x69\162\164\156\145\x74\167\x6f\162\153\56\144\145\x2f\163\x6f\141\x70\x2f\x3f\163\145\x72\166\x69\143\x65\x3d{$n2iWi}\46\167\x73\144\x6c\75\61"); goto tytBL; QKvjC: JdqcF: goto M1prF; ISEMu: return $Leok1; goto GxDYf; PlmwX: $XMsDC = $this->cache->getItem($z7xMq); goto Twkvs; y2UB_: $XMsDC->set($Leok1); goto Vq_CP; W6oS7: pJ_ff: goto uTJBu; KGQea: qhGWY: goto JvWt1; rWcne: AtBr1: goto ISEMu; G97wH: $z7xMq = md5("\x73\150\x69\x72\164\x6e\x65\164\x77\157\x72\153\x73\x6f\141\x70" . $n2iWi . $JMqvs . serialize($QHoiK)); goto PlmwX; Twkvs: if (!($ZwMRX && $XMsDC->isHit() && $XMsDC->get())) { goto JdqcF; } goto pIxiR; uTJBu: try { $Leok1 = call_user_func_array(array($rjrBe, $JMqvs), $QHoiK); } catch (\SoapFault $jTFxh) { return null; } goto u3Cop; Dc8ld: $IzAot->username = $this->systemConfigService->get("\123\150\x69\162\x74\x6e\x65\x74\x77\157\x72\153\x50\x6c\x75\147\x69\x6e\56\x63\x6f\x6e\146\151\x67\56\165\163\145\x72\x6e\x61\155\145", $qf1h6); goto b7vJC; pIxiR: return $XMsDC->get(); goto QKvjC; JqWSe: $IzAot = new \stdClass(); goto Dc8ld; b7vJC: $IzAot->password = $this->systemConfigService->get("\123\150\151\x72\x74\x6e\x65\164\x77\157\162\153\x50\x6c\x75\147\x69\x6e\56\x63\157\156\x66\x69\x67\56\160\141\x73\163\x77\x6f\x72\x64", $qf1h6); goto zkxvW; s2zjk: $rjrBe->__setSoapHeaders(array($PVxRN)); goto W6oS7; GYwD1: if (!($ZwMRX && $Leok1)) { goto AtBr1; } goto y2UB_; M1prF: if (!isset($this->_soapCache[$z7xMq])) { goto qhGWY; } goto BirK_; BirK_: return $this->_soapCache[$z7xMq]; goto KGQea; u3Cop: $this->_soapCache[$z7xMq] = $Leok1; goto GYwD1; zkxvW: $PVxRN = new \SoapHeader("\x68\164\164\x70\72\57\57\141\x70\x69\56\163\x68\x69\162\x74\x6e\145\x74\x77\x6f\162\x6b\56\144\x65\x2f\163\x6f\x61\x70\57\x3f\x73\x65\x72\x76\151\143\145\x3d" . $n2iWi, "\x61\x75\164\150\145\x6e\164\x69\x63\x61\x74\145", $IzAot); goto s2zjk; Vq_CP: $this->cache->save($XMsDC); goto rWcne; tytBL: if (!$ftrR2) { goto pJ_ff; } goto JqWSe; GxDYf: } public function getConfig(string $qf1h6, $qXwYu) { goto o51uE; FFFGL: $L0EHB = $this->GETRequest($sN3Oq); goto zbI8V; D4gwH: CmfDK: goto NO2zg; o51uE: $z7xMq = md5("\163\150\151\162\x74\156\145\164\x77\157\162\x6b\143\157\x6e\146\151\147" . $qXwYu); goto xMC2O; qU_oC: $sN3Oq .= "\57\x63\157\x6e\146\x69\x67\x2f" . $qXwYu; goto FFFGL; y_jmm: if (!($XMsDC->isHit() && $XMsDC->get())) { goto CmfDK; } goto zppcN; zppcN: return json_decode(unserialize($XMsDC->get())); goto D4gwH; qS1vW: $this->cache->save($XMsDC); goto iezUd; iezUd: return json_decode($L0EHB); goto ccwDc; NO2zg: $sN3Oq = $this->systemConfigService->get("\123\x68\151\162\x74\156\x65\164\167\x6f\x72\x6b\120\154\165\x67\151\x6e\x2e\143\157\x6e\x66\151\147\56\143\x6f\156\146\x69\x67\x73\x65\x72\x76\145\x72", $qf1h6); goto qU_oC; zbI8V: $XMsDC->set(serialize($L0EHB)); goto qS1vW; xMC2O: $XMsDC = $this->cache->getItem($z7xMq); goto y_jmm; ccwDc: } public function getConfigServerUrl(string $qf1h6) { return $this->systemConfigService->get("\123\150\151\162\x74\156\x65\x74\167\157\x72\153\x50\154\165\147\x69\156\56\x63\157\156\146\151\147\56\143\157\156\146\151\147\163\145\162\x76\145\x72", $qf1h6); } public function getSOAPUserObject(string $qf1h6) { return array("\151\x64" => $this->getUserId($qf1h6)); } public function getRest($Y9Ujw) { return json_decode($this->GETRequest("\x68\x74\164\160\x3a\57\57\x61\160\x69\x2e\163\x68\x69\162\164\x6e\x65\x74\x77\157\x72\x6b\x2e\x64\145\57\162\x65\163\x74\x2f" . $Y9Ujw)); } public function GETRequest($rL0lS) { goto Pkrf0; Jgr9Z: $I6hKy = curl_exec($c_oCw); goto fGoA6; ZNN4K: if (!isset($this->_requestCache[$z7xMq])) { goto hGFCp; } goto cLGxn; idQFG: $I6hKy = trim($I6hKy); goto Xnq0G; Xnq0G: $this->_requestCache[$z7xMq] = $I6hKy; goto HMLqi; HMLqi: return $I6hKy; goto h4tFv; ExDBj: $c_oCw = curl_init(); goto gyuD2; Pkrf0: $z7xMq = md5($rL0lS); goto ZNN4K; c5OvL: hGFCp: goto ExDBj; nwQdv: curl_setopt($c_oCw, CURLOPT_POST, 0); goto A1OpS; A1OpS: curl_setopt($c_oCw, CURLOPT_RETURNTRANSFER, 1); goto Jgr9Z; cLGxn: return $this->_requestCache[$z7xMq]; goto c5OvL; gyuD2: curl_setopt($c_oCw, CURLOPT_URL, $rL0lS); goto nwQdv; fGoA6: curl_close($c_oCw); goto idQFG; h4tFv: } public function POSTRequest($rL0lS, $zNB9S) { goto oVhzf; q2E4J: $I6hKy = curl_exec($c_oCw); goto MiJRc; YsbOi: $I6hKy = trim($I6hKy); goto qNwgr; SU8kC: curl_setopt($c_oCw, CURLOPT_RETURNTRANSFER, 1); goto pMUYT; NuuIQ: curl_setopt($c_oCw, CURLOPT_POST, 1); goto SU8kC; qNwgr: return $I6hKy; goto sqATb; MiJRc: curl_close($c_oCw); goto YsbOi; oVhzf: $c_oCw = curl_init(); goto OoETv; pMUYT: curl_setopt($c_oCw, CURLOPT_POSTFIELDS, http_build_query($zNB9S)); goto q2E4J; OoETv: curl_setopt($c_oCw, CURLOPT_URL, $rL0lS); goto NuuIQ; sqATb: } public function getAssetUrl(string $qf1h6, $aGFMs, $IolZ6) { $iTevO = $this->getUserId($qf1h6); return "\x68\164\x74\x70\x73\x3a\57\57\141\160\151\x2e\x73\x68\x69\x72\x74\156\x65\164\x77\x6f\162\x6b\56\144\145\x2f\157\x75\x74\x2f" . $aGFMs . "\57" . $iTevO . "\x2f" . $IolZ6; } public function bookCoins(string $qf1h6, $KPrFc, $gkZqc, $b7jdF = 0, $h13Pf = 0) { goto YpeRs; JkqEA: curl_setopt($c_oCw, CURLOPT_POST, 1); goto wbrnD; hS2zh: $lkx2Z = "\x68\164\x74\x70\72\x2f\x2f\141\x70\x69\x2e\163\x68\151\x72\x74\156\x65\164\x77\x6f\x72\x6b\56\x64\145\57\x73\x68\151\x72\164\x6e\145\164\167\157\x72\153\x2f\142\157\157\x6b\x2e\152\163\160"; goto wHhKS; lWvRM: curl_setopt($c_oCw, CURLOPT_POSTFIELDS, "\x75\163\x65\x72\156\x61\x6d\145\75" . $unXdZ . "\46\160\141\163\163\167\x6f\x72\144\75" . md5($J26aU) . "\46\161\165\141\156\164\x69\x74\171\75" . $KPrFc . "\x26\x6b\145\x79\x3d" . $gkZqc . "\46\141\146\x66\x69\x6c\141\x74\x65\75" . $b7jdF . "\46\160\162\157\166\151\163\151\157\x6e\x3d" . $h13Pf); goto nepe1; wHhKS: curl_setopt($c_oCw, CURLOPT_URL, $lkx2Z); goto JkqEA; qXV_E: curl_close($c_oCw); goto JPMeD; WdJrG: return trim($I6hKy); goto DD_U0; J3adh: $J26aU = $this->systemConfigService->get("\x53\150\151\162\x74\156\145\x74\x77\157\x72\153\120\154\x75\147\x69\x6e\56\x63\x6f\x6e\x66\x69\147\56\x70\141\163\163\x77\x6f\x72\x64", $qf1h6); goto s6rzl; wbrnD: curl_setopt($c_oCw, CURLOPT_RETURNTRANSFER, 1); goto lWvRM; JPMeD: $I6hKy = trim($I6hKy); goto zAhDC; s6rzl: $c_oCw = curl_init(); goto hS2zh; nepe1: $I6hKy = curl_exec($c_oCw); goto qXV_E; YpeRs: $unXdZ = $this->systemConfigService->get("\123\150\151\x72\164\156\145\x74\167\157\x72\x6b\x50\154\x75\147\151\x6e\x2e\x63\157\x6e\146\x69\x67\x2e\165\x73\145\x72\x6e\141\x6d\145", $qf1h6); goto J3adh; zAhDC: $this->bookLog($KPrFc, $gkZqc, $I6hKy, $h13Pf); goto WdJrG; DD_U0: } public function bookLog($KGyH4, $gkZqc, $Leok1, $h13Pf) { goto RxeuR; v2mSL: $Dt1PM .= "\121\165\x61\x6e\164\151\x74\171\72\40{$KGyH4}\x2c\40\117\162\144\x65\162\153\x65\x79\72\x20{$gkZqc}\x2c\x20\x50\x72\x6f\x76\x69\x73\151\157\x6e\x3a\x20{$h13Pf}\xa"; goto oOH0V; RxeuR: $Dt1PM = "\x23\43\43\43\43\43\43\x23\43\43\x23\x23\43\x23\43\43\x23\x23\x23\x23\43\x23\x23\x23\x23\43\43\43\x23\x23\x23\x23\x23\x23\x23\x23\43\x23\x23\43\43\43\x23" . "\12"; goto OUohe; OUohe: $Dt1PM .= "\133" . date("\155\57\x64\x2f\x59\x20\147\72\x69\40\101") . "\x5d\x20\x2d\x20" . "\x42\157\157\153\151\x6e\147\x20\x72\145\x73\165\154\x74\x3a\x20{$Leok1}" . "\xa"; goto v2mSL; oOH0V: $Dt1PM .= "\52\52\x2a\52\52\52\52\x2a\52\52\52\x2a\52\52\52\52\x2a\x2a\x2a\x2a\52\x2a\x2a\52\52\52\x2a\x2a\x2a\52\52\52\x2a\x2a\x2a\x2a\52\52\x2a\x2a\x2a\x2a\x2a" . "\12"; goto PVEWq; PVEWq: } public function manifestOrder(string $qf1h6, $ifACi) { goto tRZ3G; vLVHh: $o2e3Z = $ifACi->getOrderCustomer(); goto IgzIy; ncTsx: $this->POSTRequest($sN3Oq, $JbYZw); goto ih2jh; tRZ3G: $umt0a = $ifACi->getLineItems(); goto ZOa0M; ZOa0M: $Os4KR = []; goto pqYeH; h2PN7: IoRJN: goto vLVHh; Hk92A: $sN3Oq = $this->systemConfigService->get("\123\150\151\162\164\156\145\x74\167\x6f\x72\153\x50\154\x75\x67\x69\156\x2e\x63\x6f\156\x66\151\147\56\143\x6f\156\146\151\x67\163\x65\x72\166\145\x72", $qf1h6); goto FIwtr; FIwtr: $sN3Oq .= "\57\x6f\x72\x64\145\x72"; goto ncTsx; oqZIf: foreach ($umt0a as $g83FC) { goto e0HVr; Nb16t: $qXwYu = $this->getConfig($qf1h6, $q24Hq["\x73\x68\151\162\x74\x6e\x65\x74\x77\157\x72\x6b"]); goto YvvUm; i1Pp7: M3eXj: goto r08VL; RGa_c: PrfgE: goto hrZZv; NI1yR: if (!isset($q24Hq["\163\150\151\x72\x74\x6e\x65\164\167\157\162\x6b"])) { goto oqiqj; } goto mQdhg; YvvUm: foreach ($qXwYu->objects as $SM5QO) { goto C6Ds1; C6Ds1: if (!($SM5QO->type === "\165\163\145\162\x2d\154\157\x67\157")) { goto j9App; } goto etIeM; DVOju: $ORSQs = array_pop($QR3UX); goto XgYdC; XgYdC: $this->manifestUpload($qf1h6, $ORSQs); goto jwyLd; NYgML: DwNVv: goto e6qFC; etIeM: $QR3UX = explode("\57", $SM5QO->meta->original); goto DVOju; jwyLd: j9App: goto NYgML; e6qFC: } goto RGa_c; zinwI: $lv2xp[] = $g83FC->getQuantity(); goto Nb16t; e0HVr: $q24Hq = $g83FC->getPayload(); goto NI1yR; mQdhg: $Os4KR[] = $q24Hq["\163\150\151\x72\164\156\x65\x74\x77\x6f\x72\x6b"]; goto zinwI; hrZZv: oqiqj: goto i1Pp7; r08VL: } goto h2PN7; IgzIy: $JbYZw = ["\x6f\x72\144\x65\162\137\x69\x64" => $ifACi->getOrderNumber(), "\x6f\162\x64\x65\162\x5f\144\x61\x74\x65" => $ifACi->getOrderDateTime()->format("\x59\55\x6d\55\144\40\x48\72\151\x3a\163"), "\143\165\163\x74\157\x6d\x65\x72\137\156\141\155\145" => $o2e3Z->getFirstName() . "\40" . $o2e3Z->getLastName(), "\143\x6f\156\146\x69\147\x73" => $Os4KR, "\x61\x6d\x6f\165\x6e\x74\x73" => $lv2xp]; goto Hk92A; pqYeH: $lv2xp = []; goto oqZIf; ih2jh: } public function getResourceLink(string $qf1h6, $aGFMs, $QR3UX) { goto V8n3n; fC0YP: $okXei .= $QR3UX; goto FpFLy; Ucdvx: $okXei .= $this->getUserId($qf1h6) . "\57"; goto fC0YP; bjSza: $okXei .= "{$aGFMs}\x2f"; goto Ucdvx; V8n3n: $okXei = "\x68\x74\x74\160\x3a\x2f\x2f\141\x70\151\56\x73\150\151\x72\164\x6e\145\x74\x77\157\x72\x6b\56\x64\x65"; goto VJW6F; FpFLy: return $okXei; goto XAake; VJW6F: $okXei .= "\x2f\x6f\x75\x74\x2f"; goto bjSza; XAake: } public function manifestUpload(string $qf1h6, $nEAey) { goto uV0SF; uV0SF: $sN3Oq = str_replace("\x2f\146\151\x6c\x65\163", '', $this->systemConfigService->get("\123\x68\x69\162\x74\156\145\164\167\x6f\x72\x6b\x50\154\x75\x67\151\x6e\x2e\x63\157\x6e\x66\151\147\x2e\165\160\x6c\x6f\x61\144\163\x65\162\166\145\x72", $qf1h6)); goto lZeA1; f7qG4: $PDtKR = $this->GETRequest($sN3Oq); goto dWm9v; lZeA1: $sN3Oq .= "\57\155\x61\156\x69\146\145\163\x74\57" . $nEAey; goto f7qG4; dWm9v: } public function currencyConvert($CzpGx, $OSJh_, $N6h1c = 0) { goto yJuO2; bm_OD: try { goto s1v5_; s1v5_: $wT0fD = $this->redir_curl($rL0lS); goto E5Xk4; j29RS: NKfB_: goto fZno4; KPMOG: return null; goto j29RS; fZno4: return (float) $wT0fD * 1.0; goto Q295q; E5Xk4: if ($wT0fD) { goto NKfB_; } goto KPMOG; Q295q: } catch (Exception $UKdDw) { goto flODi; flODi: if (!($N6h1c == 0)) { goto KkJTp; } goto GOvPq; DUnIM: KkJTp: goto k1haO; GOvPq: return $this->currencyConvert($CzpGx, $OSJh_, 1); goto DUnIM; k1haO: } goto FtZob; yJuO2: $rL0lS = str_replace("\173\173\103\125\x52\122\x45\116\x43\131\137\106\122\117\x4d\x7d\175", $CzpGx, "\150\164\164\x70\72\57\57\161\165\x6f\x74\145\x2e\x79\141\x68\157\157\56\143\157\x6d\57\144\57\x71\165\x6f\164\145\x73\56\x63\163\166\77\163\x3d\173\x7b\x43\x55\x52\x52\105\x4e\x43\131\x5f\106\122\x4f\x4d\175\175\173\173\103\125\122\x52\x45\116\x43\x59\x5f\x54\117\175\x7d\75\x58\46\146\75\154\x31\x26\x65\75\x2e\x63\x73\x76"); goto LGII1; LGII1: $rL0lS = str_replace("\x7b\173\x43\x55\122\x52\105\116\103\131\137\124\117\175\x7d", $OSJh_, $rL0lS); goto bm_OD; FtZob: } private function redir_curl($rL0lS) { goto N0Piz; u4NVp: goto KobYE; goto IOVDM; VS5SW: if (ini_get("\157\x70\x65\x6e\137\142\141\x73\x65\x64\x69\x72") == '' && ini_get("\x73\x61\146\145\x5f\155\x6f\144\x65" == "\117\146\146")) { goto qrcOL; } goto s3mNI; gCxsc: curl_setopt($LmmYt, CURLOPT_URL, $rL0lS); goto VS5SW; SRW0V: KobYE: goto cMVAp; dpvVO: return $OiqdC; goto ZCXFK; N0Piz: $LmmYt = curl_init($rL0lS); goto gCxsc; IOVDM: qrcOL: goto Z8SHE; bngdg: $OiqdC = curl_exec($LmmYt); goto SRW0V; s3mNI: $OiqdC = $this->curl_redir_exec($LmmYt); goto u4NVp; cMVAp: curl_close($LmmYt); goto dpvVO; Z8SHE: curl_setopt($LmmYt, CURLOPT_FOLLOWLOCATION, D4VKZ); goto bngdg; ZCXFK: } private function curl_redir_exec($c_oCw) { goto ptcOs; ptcOs: static $SF3Gu = 0; goto s732Y; zQrNh: JafGF: goto kk42R; JPIgW: rnwMo: goto e1jLw; XjCVj: list($TD_7y, $Utu1S) = explode("\xa\xd", $Utu1S, 2); goto ByyS9; SH5vp: th4nf: goto F0XcU; QrwA7: QnrTv: goto XGzup; JPNXk: curl_setopt($c_oCw, CURLOPT_URL, $C2DMq); goto aalSt; A9Hek: if (!($SF3Gu++ >= $dgVkb)) { goto JafGF; } goto aKPgN; ByyS9: $HNCcW = curl_getinfo($c_oCw, CURLINFO_HTTP_CODE); goto W4Rfe; WAcqm: return $Utu1S; goto pZdG7; jpsoA: $rL0lS["\160\141\x74\150"] = $s2iOA["\x70\141\164\150"]; goto EwRCK; F0XcU: if ($rL0lS["\x70\x61\x74\150"]) { goto agF1T; } goto jpsoA; s732Y: static $dgVkb = 20; goto A9Hek; p3Gpe: $rL0lS["\x68\157\163\164"] = $s2iOA["\150\x6f\163\x74"]; goto SH5vp; EcRs1: return FALSE; goto zQrNh; cozvF: ZMYiW: goto bFi1n; pZdG7: Bz1Jx: goto B7ePZ; LGoQ9: if ($rL0lS) { goto Bz1Jx; } goto No7_Y; No7_Y: $SF3Gu = 0; goto WAcqm; e1jLw: $eqNav = array(); goto xnVaw; xLeD8: $SF3Gu = 0; goto QAa4L; KwJ0_: $rL0lS["\163\x63\x68\x65\x6d\x65"] = $s2iOA["\163\143\x68\x65\x6d\145"]; goto QrwA7; y6WdG: $rL0lS = @parse_url(trim(array_pop($eqNav))); goto LGoQ9; HyZwh: if ($rL0lS["\x73\143\x68\145\x6d\x65"]) { goto QnrTv; } goto KwJ0_; LZAw0: $Utu1S = curl_exec($c_oCw); goto XjCVj; EwRCK: agF1T: goto SoT1L; W4Rfe: if ($HNCcW == 301 || $HNCcW == 302) { goto rnwMo; } goto xLeD8; QAa4L: return $Utu1S; goto Fdb6Q; SoT1L: $C2DMq = $rL0lS["\x73\143\x68\145\x6d\145"] . "\x3a\x2f\57" . $rL0lS["\x68\x6f\x73\164"] . $rL0lS["\160\x61\x74\150"] . ($rL0lS["\161\x75\145\x72\171"] ? "\77" . $rL0lS["\x71\x75\x65\x72\x79"] : ''); goto JPNXk; wB2bg: curl_setopt($c_oCw, CURLOPT_RETURNTRANSFER, true); goto LZAw0; xnVaw: preg_match("\x2f\114\x6f\x63\x61\164\151\157\x6e\x3a\50\56\x2a\77\51\x5c\x6e\x2f", $TD_7y, $eqNav); goto y6WdG; aalSt: return $this->curl_redir_exec($c_oCw); goto cozvF; kk42R: curl_setopt($c_oCw, CURLOPT_HEADER, true); goto wB2bg; aKPgN: $SF3Gu = 0; goto EcRs1; B7ePZ: $s2iOA = parse_url(curl_getinfo($c_oCw, CURLINFO_EFFECTIVE_URL)); goto HyZwh; XGzup: if ($rL0lS["\150\x6f\163\x74"]) { goto th4nf; } goto p3Gpe; Fdb6Q: goto ZMYiW; goto JPIgW; bFi1n: } }