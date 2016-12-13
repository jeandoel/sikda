-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Dec 12, 2014 at 10:59 AM
-- Server version: 5.6.20
-- PHP Version: 5.5.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

SET FOREIGN_KEY_CHECKS=0;

DROP TABLE IF EXISTS `map_gigi_permukaan`;
DROP TABLE IF EXISTS `mst_gigi_permukaan`;
DROP TABLE IF EXISTS `mst_gigi`;
DROP TABLE IF EXISTS `mst_gigi_status`;
DROP TABLE IF EXISTS `t_foto_gigi_pasien`;
DROP TABLE IF EXISTS `t_perawatan_gigi_pasien`;

CREATE TABLE IF NOT EXISTS `mst_icd` (
  `KD_PENYAKIT` varchar(20) NOT NULL,
  `KD_ICD_INDUK` varchar(20) NOT NULL,
  `PENYAKIT` varchar(500) DEFAULT NULL,
  `INCLUDES` varchar(20) DEFAULT NULL,
  `EXCLUDES` varchar(20) DEFAULT NULL,
  `NOTES` varchar(255) DEFAULT NULL,
  `STATUS_APP` varchar(255) DEFAULT NULL,
  `DESCRIPTION` varchar(255) DEFAULT NULL,
  `IS_DEFAULT` smallint(1) DEFAULT NULL,
  `IS_ODONTOGRAM` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0 bukan odontogram, 1 odontogram',
  `ninput_oleh` varchar(10) DEFAULT NULL,
  `ninput_tgl` datetime DEFAULT NULL,
  `nupdate_oleh` varchar(10) DEFAULT NULL,
  `nupdate_tgl` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;



--
-- Dumping data for table `mst_icd`
--

DELETE FROM mst_icd where
KD_PENYAKIT IN (
'K00','K00.0','K00.1','K00.2','K00.3','K00.4','K00.5','K00.6','K00.7','K00.8','K00.9','K01','K01.0','K01.1','K02','K02.0','K02.1','K02.2','K02.3','K02.4','K02.8','K02.9','K03','K03.0','K03.1','K03.2','K03.3','K03.4','K03.5','K03.6','K03.7','K03.8','K03.9','K04','K04.0','K04.1','K04.2','K04.3','K04.4','K04.5','K04.6','K04.7','K04.8','K04.9','K05','K05.0','K05.1','K05.2','K05.3','K05.4','K05.5','K05.6','K06','K06.0','K06.1','K06.2','K06.8','K06.9','K07','K07.0','K07.1','K07.2','K07.3','K07.4','K07.5','K07.6','K07.8','K07.9','K08','K08.0','K08.1','K08.2','K08.3','K08.8','K08.9','K09','K09.0','K09.1','K09.2','K09.8','K09.9','K10','K10.0','K10.1','K10.2','K10.3','K10.8','K10.9','K11','K11.0','K11.1','K11.2','K11.3','K11.4','K11.5','K11.6','K11.7','K11.8','K11.9','K12','K12.0','K12.1','K12.2','K13','K13.0','K13.1','K13.2','K13.3','K13.4','K13.5','K13.6','K13.7','K14','K14.0','K14.1','K14.2','K14.3','K14.4','K14.5','K14.6','K14.8','K14.9'
);


INSERT INTO `mst_icd` (`KD_PENYAKIT`, `KD_ICD_INDUK`, `PENYAKIT`, `INCLUDES`, `EXCLUDES`, `NOTES`, `STATUS_APP`, `DESCRIPTION`, `IS_DEFAULT`, `IS_ODONTOGRAM`, `ninput_oleh`, `ninput_tgl`, `nupdate_oleh`, `nupdate_tgl`) VALUES
('K00', 'K00-K14', 'Disorders of tooth development and eruption', '', 'th (K01.-)', '', '', '', 0, 1, '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00'),
('K00.0', 'K00-K14', 'Anodontia', '', '', '', '', 'Hypodontia Oligodontia', 0, 1, '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00'),
('K00.1', 'K00-K14', 'Supernumerary teeth', '', '', '', '', 'Distomolar Fourth molar Mesiodens Paramolar Supplementary teeth', 0, 1, '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00'),
('K00.2', 'K00-K14', 'Abnormalities of size and form of teeth', '', '. invaginatus Enamel', '', '', 'Concrescence  ) Fusion        )  of teeth Gemination    ) Dens: . evaginatus . in dente . invaginatus Enamel pearls Macrodontia Microdontia Peg-shaped [conical] teeth Taurodontism Tuberculum paramolare', 0, 1, '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00'),
('K00.3', 'K00-K14', 'Mottled teeth', '', 'luoride enamel opaci', '', '', 'Dental fluorosis Mottling of enamel Nonfluoride enamel opacities', 0, 1, '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00'),
('K00.4', 'K00-K14', 'Disturbances in tooth formation', '', 'al)(prenatal) Region', '', '', 'Aplasia and hypoplasia of cementum Dilaceration of tooth Enamel hypoplasia (neonatal)(postnatal)(prenatal) Regional odontodysplasia Turners tooth', 0, 1, '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00'),
('K00.5', 'K00-K14', 'Hereditary disturbances in tooth structure, not elsewhere', '', '', '', '', 'classified Amelogenesis    ) Dentinogenesis  )  imperfecta Odontogenesis   ) Dentinal dysplasia Shell teeth', 0, 1, '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00'),
('K00.6', 'K00-K14', 'Disturbances in tooth eruption', '', '', '', '', 'Dentia praecox Natal    ) Neonatal ) tooth Premature: . eruption of tooth . shedding of primary [deciduous] tooth Retained [persistent] primary tooth', 0, 1, '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00'),
('K00.7', 'K00-K14', 'Teething syndrome', '', '', '', '', '', 0, 1, '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00'),
('K00.8', 'K00-K14', 'Other disorders of tooth development', '', '', '', '', 'Colour changes during tooth formation Intrinsic staining of teeth NOS', 0, 1, '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00'),
('K00.9', 'K00-K14', 'Disorder of tooth development, unspecified', '', '', '', '', 'Disorder of odontogenesis NOS', 0, 1, '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00'),
('K01', 'K00-K14', 'Embedded and impacted teeth', '', 'th (K07.3)', '', '', '', 0, 1, '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00'),
('K01.0', 'K00-K14', 'Embedded teeth', '', '', '', '', 'An embedded tooth is a tooth that has failed to erupt without obstruction by another tooth.', 0, 1, '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00'),
('K01.1', 'K00-K14', 'Impacted teeth', '', '', '', '', 'An impacted tooth is a tooth that has failed to erupt because of obstruction by another tooth.', 0, 1, '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00'),
('K02', 'K00-K14', 'karies gigi', '', '', '', '', '', 1, 1, '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00'),
('K02.0', 'K00-K14', 'Caries limited to enamel', '', '', '', '', 'White spot lesions [initial caries]', 0, 1, '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00'),
('K02.1', 'K00-K14', 'Caries of dentine', '', '', '', '', '', 0, 1, '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00'),
('K02.2', 'K00-K14', 'Caries of cementum', '', '', '', '', '', 0, 1, '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00'),
('K02.3', 'K00-K14', 'Arrested dental caries', '', '', '', '', '', 0, 1, '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00'),
('K02.4', 'K00-K14', 'Odontoclasia', '', '', '', '', 'Infantile melanodontia Melanodontoclasia', 0, 1, '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00'),
('K02.8', 'K00-K14', 'Other dental caries', '', '', '', '', '', 0, 1, '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00'),
('K02.9', 'K00-K14', 'Dental caries, unspecified', '', '', '', '', '', 1, 1, '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00'),
('K03', 'K00-K14', 'Other diseases of hard tissues of teeth', '', 'OS (F45.8)', '', '', '', 0, 1, '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00'),
('K03.0', 'K00-K14', 'Excessive attrition of teeth', '', '', '', '', 'Wear: . approximal  ) . occlusal    )  of teeth', 0, 1, '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00'),
('K03.1', 'K00-K14', 'Abrasion of teeth', '', '', '', '', 'Abrasion: . dentifrice     ) . habitual       ) . occupational   ) . ritual         )  of teeth . traditional    ) Wedge defect NOS )', 0, 1, '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00'),
('K03.2', 'K00-K14', 'Erosion of teeth', '', '', '', '', 'Erosion of teeth: . NOS . due to: . diet . drugs and medicaments . persistent vomiting . idiopathic . occupational', 0, 1, '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00'),
('K03.3', 'K00-K14', 'Pathological resorption of teeth', '', '', '', '', 'Internal granuloma of pulp Resorption of teeth (external)', 0, 1, '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00'),
('K03.4', 'K00-K14', 'Hypercementosis', '', '', '', '', 'Cementation hyperplasia', 0, 1, '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00'),
('K03.5', 'K00-K14', 'Ankylosis of teeth', '', '', '', '', '', 0, 1, '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00'),
('K03.6', 'K00-K14', 'Deposits [accretions] on teeth', '', '', '', '', 'Dental calculus: . subgingival . supragingival Deposits [accretions] on teeth: . betel . black . green . materia alba . orange . tobacco Staining of teeth: . NOS . extrinsic NOS', 0, 1, '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00'),
('K03.7', 'K00-K14', 'Posteruptive colour changes of dental hard tissues', '', 'th (K03.6)', '', '', '', 0, 1, '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00'),
('K03.8', 'K00-K14', 'Other specified diseases of hard tissues of teeth', '', '', '', '', 'Irradiated enamel Sensitive dentine Use additional external cause code (Chapter XX), if desired, to identify radiation, if radiation-induced.', 0, 1, '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00'),
('K03.9', 'K00-K14', 'Disease of hard tissues of teeth, unspecified', '', '', '', '', '', 0, 1, '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00'),
('K04', 'K00-K14', 'Penyakit Pulpa dan jaringan periapikal', '', '', '', '', '', 1, 1, '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00'),
('K04.0', 'K00-K14', 'Pulpitis', '', '', '', '', 'Pulpal: . abscess . polyp Pulpitis: . acute . chronic (hyperplastic)(ulcerative) . suppurative', 1, 1, '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00'),
('K04.1', 'K00-K14', 'Necrosis of pulp', '', '', '', '', 'Pulpal gangrene', 0, 1, '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00'),
('K04.2', 'K00-K14', 'Pulp degeneration', '', '', '', '', 'Denticles Pulpal: . calcifications . stones', 0, 1, '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00'),
('K04.3', 'K00-K14', 'Abnormal hard tissue formation in pulp', '', '', '', '', 'Secondary or irregular dentine', 0, 1, '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00'),
('K04.4', 'K00-K14', 'Acute apical periodontitis of pulpal origin', '', '', '', '', 'Acute apical periodontitis NOS', 0, 1, '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00'),
('K04.5', 'K00-K14', 'Chronic apical periodontitis', '', '', '', '', 'Apical or periapical granuloma Apical periodontitis NOS', 0, 1, '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00'),
('K04.6', 'K00-K14', 'Periapical abscess with sinus', '', '', '', '', 'Dental        ) Dentoalveolar ) abscess with sinus', 0, 1, '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00'),
('K04.7', 'K00-K14', 'Periapical abscess without sinus', '', '', '', '', 'Dental        ) Dentoalveolar ) abscess NOS Periapical    )', 0, 1, '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00'),
('K04.8', 'K00-K14', 'Radicular cyst', '', 'iapical . residual r', '', '', 'Cyst: . apical (periodontal) . periapical . residual radicular', 0, 1, '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00'),
('K04.9', 'K00-K14', 'Other and unspecified diseases of pulp and periapical tissue', '', '', '', '', '', 0, 1, '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00'),
('K05', 'K00-K14', 'Penyakit gusi dan periodontal', '', '', '', '', '', 0, 1, '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00'),
('K05.0', 'K00-K14', 'Acute gingivitis', '', 'is (B00.2)', '', '', '', 0, 1, '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00'),
('K05.1', 'K00-K14', 'Chronic gingivitis', '', '', '', '', 'Gingivitis (chronic): . NOS . desquamative . hyperplastic . simple marginal . ulcerative', 0, 1, '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00'),
('K05.2', 'K00-K14', 'Acute periodontitis', '', 'periodontitis (K04.4', '', '', 'Acute pericoronitis Parodontal abscess Periodontal abscess', 0, 1, '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00'),
('K05.3', 'K00-K14', 'Chronic periodontitis', '', '', '', '', 'Chronic pericoronitis Periodontitis: . NOS . complex . simplex', 0, 1, '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00'),
('K05.4', 'K00-K14', 'Periodontosis', '', '', '', '', 'Juvenile periodontosis', 0, 1, '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00'),
('K05.5', 'K00-K14', 'Other periodontal diseases', '', '', '', '', '', 0, 1, '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00'),
('K05.6', 'K00-K14', 'Periodontal disease, unspecified', '', '', '', '', '', 0, 1, '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00'),
('K06', 'K00-K14', 'Other disorders of gingiva and edentulous alveolar ridge', '', 'ic (K05.1)', '', '', '', 0, 1, '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00'),
('K06.0', 'K00-K14', 'Gingival recession', '', '', '', '', 'Gingival recession (generalized)(localized)(postinfective) (postoperative)', 0, 1, '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00'),
('K06.1', 'K00-K14', 'Gingival enlargement', '', '', '', '', 'Gingival fibromatosis', 0, 1, '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00'),
('K06.2', 'K00-K14', 'Gingival and edentulous alveolar ridge lesions associated wi', '', '', '', '', 'trauma Irritative hyperplasia of edentulous ridge [denture hyperplasia] Use additional external cause code (Chapter XX), if desired, to identify cause.', 0, 1, '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00'),
('K06.8', 'K00-K14', 'Other specified disorders of gingiva and edentulous alveolar', '', '', '', '', 'Fibrous epulis Flabby ridge Giant cell epulis Peripheral giant cell granuloma Pyogenic granuloma of gingiva', 0, 1, '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00'),
('K06.9', 'K00-K14', 'Disorder of gingiva and edentulous alveolar ridge, unspecifi', '', '', '', '', '', 0, 1, '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00'),
('K07', 'K00-K14', 'Dentofacial anomalies [including malocclusion]', '', 'ia (K10.8)', '', '', '', 0, 1, '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00'),
('K07.0', 'K00-K14', 'Major anomalies of jaw size', '', 'lary Macrognathism (', '', '', 'Hyperplasia, hypoplasia: . mandibular . maxillary Macrognathism (mandibular)(maxillary) Micrognathism (mandibular)(maxillary)', 0, 1, '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00'),
('K07.1', 'K00-K14', 'Anomalies of jaw-cranial base relationship', '', '', '', '', 'Asymmetry of jaw Prognathism (mandibular)(maxillary) Retrognathism (mandibular)(maxillary)', 0, 1, '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00'),
('K07.2', 'K00-K14', 'Anomalies of dental arch relationship', '', '', '', '', 'Crossbite (anterior)(posterior) Disto-occlusion Mesio-occlusion Midline deviation of dental arch Openbite (anterior)(posterior) Overbite (excessive): . deep . horizontal . vertical Overjet Posterior lingual occlusion of mandibular teeth', 0, 1, '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00'),
('K07.3', 'K00-K14', 'Anomalies of tooth position', '', 'ation          )  of', '', '', 'Crowding          ) Diastema          ) Displacement      ) Rotation          )  of tooth or teeth Spacing, abnormal ) Transposition     ) Impacted or embedded teeth with abnormal position of such  teeth or adjacent teeth', 0, 1, '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00'),
('K07.4', 'K00-K14', 'Malocclusion, unspecified', '', '', '', '', '', 0, 1, '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00'),
('K07.5', 'K00-K14', 'Dentofacial functional abnormalities', '', 'abnormal swallowing ', '', '', 'Abnormal jaw closure Malocclusion due to: . abnormal swallowing . mouth breathing . tongue, lip or finger habits', 0, 1, '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00'),
('K07.6', 'K00-K14', 'Temporomandibular joint disorders', '', 'ing jaw Temporomandi', '', '', 'Costens complex or syndrome Derangement of temporomandibular joint Snapping jaw Temporomandibular joint-pain-dysfunction syndrome', 0, 1, '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00'),
('K07.8', 'K00-K14', 'Other dentofacial anomalies', '', '', '', '', '', 0, 1, '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00'),
('K07.9', 'K00-K14', 'Dentofacial anomaly, unspecified', '', '', '', '', '', 0, 1, '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00'),
('K08', 'K00-K14', 'Gangguan gigi dan jaringan penunjang lainnya', '', '', '', '', '', 0, 1, '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00'),
('K08.0', 'K00-K14', 'Exfoliation of teeth due to systemic causes', '', '', '', '', '', 1, 1, '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00'),
('K08.1', 'K00-K14', 'Loss of teeth due to accident, extraction or local periodont', '', '', '', '', 'disease', 0, 1, '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00'),
('K08.2', 'K00-K14', 'Atrophy of edentulous alveolar ridge', '', '', '', '', '', 0, 1, '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00'),
('K08.3', 'K00-K14', 'Retained dental root', '', '', '', '', '', 0, 1, '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00'),
('K08.8', 'K00-K14', 'Other specified disorders of teeth and supporting structures', '', '', '', '', 'Enlargement of alveolar ridge NOS Irregular alveolar process Toothache NOS', 0, 1, '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00'),
('K08.9', 'K00-K14', 'Disorder of teeth and supporting structures, unspecified', '', '', '', '', '', 1, 1, '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00'),
('K09', 'K00-K14', 'Cysts of oral region, not elsewhere classified', ': ', 'ing histological fea', '', '', '', 0, 1, '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00'),
('K09.0', 'K00-K14', 'Developmental odontogenic cysts', '', '', '', '', 'Cyst: . dentigerous . eruption . follicular . gingival . lateral periodontal . primordial Keratocyst', 0, 1, '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00'),
('K09.1', 'K00-K14', 'Developmental (nonodontogenic) cysts of oral region', '', '', '', '', 'Cyst (of): . globulomaxillary . incisive canal . median palatal . nasopalatine . palatine papilla', 0, 1, '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00'),
('K09.2', 'K00-K14', 'Other cysts of jaw', '', 'tic Excludes:   late', '', '', 'Cyst of jaw: . NOS . aneurysmal . haemorrhagic . traumatic', 0, 1, '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00'),
('K09.8', 'K00-K14', 'Other cysts of oral region, not elsewhere classified', '', '', '', '', 'Dermoid cyst          ) Epidermoid cyst       ) of mouth Lymphoepithelial cyst ) Epsteins pearl Nasoalveolar cyst Nasolabial cyst', 0, 1, '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00'),
('K09.9', 'K00-K14', 'Cyst of oral region, unspecified', '', '', '', '', '', 0, 1, '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00'),
('K10', 'K00-K14', 'Other diseases of jaws', '', '', '', '', '', 0, 1, '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00'),
('K10.0', 'K00-K14', 'Developmental disorders of jaws', '', '', '', '', 'Latent bone cyst of jaw Stafnes cyst Torus: . mandibularis . palatinus', 0, 1, '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00'),
('K10.1', 'K00-K14', 'Giant cell granuloma, central', '', 'pheral giant cell gr', '', '', 'Giant cell granuloma NOS', 0, 1, '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00'),
('K10.2', 'K00-K14', 'Inflammatory conditions of jaws', '', '', '', '', 'Osteitis                 ) Osteomyelitis (neonatal) ) of jaw (acute)(chronic) Osteoradionecrosis       )   (suppurative) Periostitis              ) Sequestrum of jaw bone Use additional external cause code (Chapter XX), if desired, to identify radiation, ', 0, 1, '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00'),
('K10.3', 'K00-K14', 'Alveolitis of jaws', '', '', '', '', 'Alveolar osteitis Dry socket', 0, 1, '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00'),
('K10.8', 'K00-K14', 'Other specified diseases of jaws', '', '', '', '', 'Cherubism Exostosis         ) of jaw Fibrous dysplasia ) Unilateral condylar: . hyperplasia . hypoplasia', 0, 1, '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00'),
('K10.9', 'K00-K14', 'Disease of jaws, unspecified', '', '', '', '', '', 0, 1, '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00'),
('K11', 'K00-K14', 'Diseases of salivary glands', '', '', '', '', '', 0, 1, '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00'),
('K11.0', 'K00-K14', 'Atrophy of salivary gland', '', '', '', '', '', 0, 1, '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00'),
('K11.1', 'K00-K14', 'Hypertrophy of salivary gland', '', '', '', '', '', 0, 1, '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00'),
('K11.2', 'K00-K14', 'Sialoadenitis', '', 't] (D86.8)', '', '', '', 0, 1, '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00'),
('K11.3', 'K00-K14', 'Abscess of salivary gland', '', '', '', '', '', 0, 1, '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00'),
('K11.4', 'K00-K14', 'Fistula of salivary gland', '', 'nd (Q38.4)', '', '', '', 0, 1, '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00'),
('K11.5', 'K00-K14', 'Sialolithiasis', '', '', '', '', 'Calculus ) Stone    ) of salivary gland or duct', 0, 1, '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00'),
('K11.6', 'K00-K14', 'Mucocele of salivary gland', '', '', '', '', 'Mucous: . extravasation cyst ) . retention cyst     ) of salivary gland Ranula', 0, 1, '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00'),
('K11.7', 'K00-K14', 'Disturbances of salivary secretion', '', 'erostomia Excludes: ', '', '', 'Hypoptyalism Ptyalism Xerostomia', 0, 1, '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00'),
('K11.8', 'K00-K14', 'Other diseases of salivary glands', '', 'salivary gland Mikul', '', '', 'Benign lymphoepithelial lesion of salivary gland Mikulicz disease Necrotizing sialometaplasia Sialectasia Stenosis  ) Stricture ) of salivary duct', 0, 1, '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00'),
('K11.9', 'K00-K14', 'Disease of salivary gland, unspecified', '', '', '', '', 'Sialoadenopathy NOS', 0, 1, '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00'),
('K12', 'K00-K14', 'Stomatitis and related lesions', '', 'ma (A69.0)', '', '', '', 0, 1, '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00'),
('K12.0', 'K00-K14', 'Sariawan / Recurrent oral aphthae', '', '', '', '', 'Aphthous stomatitis (major)(minor) Bednars aphthae Periadenitis mucosa necrotica recurrens Recurrent aphthous ulcer Stomatitis herpetiformis', 1, 1, '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00'),
('K12.1', 'K00-K14', 'Other forms of stomatitis', '', '', '', '', 'Stomatitis: . NOS . denture . ulcerative . vesicular', 0, 1, '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00'),
('K12.2', 'K00-K14', 'Cellulitis and abscess of mouth', '', 'eritonsillar (J36) .', '', '', 'Cellulitis of mouth (floor) Submandibular abscess', 0, 1, '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00'),
('K13', 'K00-K14', 'Other diseases of lip and oral mucosa', ': ', 'of tongue (K14.-) st', '', '', '', 0, 1, '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00'),
('K13.0', 'K00-K14', 'Diseases of lips', '', 'related disorders (L', '', '', 'Cheilitis: . NOS . angular . exfoliative . glandular Cheilodynia Cheilosis PerlŠche NEC', 0, 1, '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00'),
('K13.1', 'K00-K14', 'Cheek and lip biting', '', '', '', '', '', 0, 1, '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00'),
('K13.2', 'K00-K14', 'Leukoplakia and other disturbances of oral epithelium, inclu', '', 'ral epithelium, Leuk', '', '', 'tongue Erythroplakia ) of oral epithelium, Leukoedema    )  including tongue Leukokeratosis nicotina palati Smokers palate', 0, 1, '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00'),
('K13.3', 'K00-K14', 'Hairy leukoplakia', '', '', '', '', '', 0, 1, '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00'),
('K13.4', 'K00-K14', 'Granuloma and granuloma-like lesions of oral mucosa', '', '', '', '', 'Eosinophilic granuloma ) Granuloma pyogenicum   ) of oral mucosa Verrucous xanthoma     )', 0, 1, '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00'),
('K13.5', 'K00-K14', 'Oral submucous fibrosis', '', '', '', '', 'Submucous fibrosis of tongue', 0, 1, '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00'),
('K13.6', 'K00-K14', 'Irritative hyperplasia of oral mucosa', '', 'a] (K06.2)', '', '', '', 0, 1, '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00'),
('K13.7', 'K00-K14', 'Other and unspecified lesions of oral mucosa', '', '', '', '', 'Focal oral mucinosis', 0, 1, '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00'),
('K14', 'K00-K14', 'Diseases of tongue', '', 'ue (K13.5)', '', '', '', 0, 1, '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00'),
('K14.0', 'K00-K14', 'Glossitis', '', 'eration (traumatic) ', '', '', 'Abscess                ) Ulceration (traumatic) ) of tongue', 0, 1, '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00'),
('K14.1', 'K00-K14', 'Geographic tongue', '', '', '', '', 'Benign migratory glossitis Glossitis areata exfoliativa', 0, 1, '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00'),
('K14.2', 'K00-K14', 'Median rhomboid glossitis', '', '', '', '', '', 0, 1, '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00'),
('K14.3', 'K00-K14', 'Hypertrophy of tongue papillae', '', '', '', '', 'Black hairy tongue Coated tongue Hypertrophy of foliate papillae Lingua villosa nigra', 0, 1, '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00'),
('K14.4', 'K00-K14', 'Atrophy of tongue papillae', '', '', '', '', 'Atrophic glossitis', 0, 1, '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00'),
('K14.5', 'K00-K14', 'Plicated tongue', '', ') Excludes:   fissur', '', '', 'Fissured ) Furrowed ) tongue Scrotal  )', 0, 1, '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00'),
('K14.6', 'K00-K14', 'Glossodynia', '', '', '', '', 'Glossopyrosis Painful tongue', 0, 1, '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00'),
('K14.8', 'K00-K14', 'Other diseases of tongue', '', '', '', '', 'Atrophy     ) Crenated    ) Enlargement ) (of) tongue Hypertrophy )', 0, 1, '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00'),
('K14.9', 'K00-K14', 'Disease of tongue, unspecified', '', '', '', '', 'Glossopathy NOS', 0, 1, '', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `mst_produk`
--

CREATE TABLE IF NOT EXISTS `mst_produk` (
  `KD_PUSKESMAS` varchar(20) DEFAULT NULL,
  `KD_PRODUK` int(20) NOT NULL,
  `KD_GOL_PRODUK` varchar(20) DEFAULT NULL,
  `PRODUK` varchar(255) DEFAULT NULL,
  `HARGA_PRODUK` varchar(20) DEFAULT NULL,
  `SINGKATAN` varchar(255) DEFAULT NULL,
  `IS_DEFAULT` smallint(1) NOT NULL,
  `IS_ODONTOGRAM` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0 adalah odontogram 1 adalah odontogram',
  `ninput_oleh` varchar(20) DEFAULT NULL,
  `ninput_tgl` datetime DEFAULT NULL,
  `nupdate_oleh` varchar(20) DEFAULT NULL,
  `nupdate_tgl` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;


--
-- Dumping data for table `mst_produk`
--

DELETE FROM mst_produk WHERE KD_PRODUK IN (
  '29','31','32','33','34','48','49','51','52','151','154','157','160','163','470','471','874','875','876','877','878','879','880','881','882','883','884','885','886','887','889'
  );



INSERT INTO `mst_produk` (`KD_PUSKESMAS`, `KD_PRODUK`, `KD_GOL_PRODUK`, `PRODUK`, `HARGA_PRODUK`, `SINGKATAN`, `IS_DEFAULT`, `IS_ODONTOGRAM`, `ninput_oleh`, `ninput_tgl`, `nupdate_oleh`, `nupdate_tgl`) VALUES
(NULL, 29, '413', 'Pemeriksaan', '10000', '1', 1, 1, NULL, NULL, 'all', '2014-11-27 02:03:09'),
(NULL, 31, '413', 'Pencabutan Gigi Sulung Tropical', '10000', '1', 1, 1, NULL, NULL, 'all', '2014-11-27 02:02:51'),
(NULL, 32, '413', 'Pencabutan Gigi Sulung Infiltrasi', '10000', '1', 1, 1, NULL, NULL, 'all', '2014-11-27 02:02:38'),
(NULL, 33, '413', 'Pencabutan Gigi Permanen Tanpa Penyulit', '10000', '1', 1, 1, NULL, NULL, 'all', '2014-11-27 02:04:14'),
(NULL, 48, '413', 'Gigi Tiruan Sebagian Akrilik', '10000', '1', 1, 1, NULL, NULL, 'all', '2014-11-27 02:04:42'),
(NULL, 51, '413', 'Gigi Tiruan Akrilik Per Rahang', '10000', '1', 1, 1, NULL, NULL, 'all', '2014-11-27 02:05:01'),
(NULL, 52, '413', 'Reparasi Gigi Tiruan', '10000', '1', 1, 1, NULL, NULL, 'all', '2014-11-27 02:05:14'),
(NULL, 874, '413', 'Tumpatan GIC', '89.31; 23.49', 1, 1, 'all', '2014-11-27 01:49:56', 'all', '2014-11-27 01:50:54'),
(NULL, 875, '413', 'Tumpatan GIC Dengan Pulp Capping', '10000', '23.2; 23.70', 1, 1, 'all', '2014-11-27 01:51:14', NULL, NULL),
(NULL, 876, '413', 'Tumpatan Komposit', '10000', '23.49; 23.2', 1, 1, 'all', '2014-11-27 01:51:47', NULL, NULL),
(NULL, 877, '413', 'Tumpatan Komposit Dengan Pulp Capping', '10000', '23.2; 23.49;  23.70', 1, 1, 'all', '2014-11-27 01:52:21', NULL, NULL),
(NULL, 878, '413', 'Fissure Sealant', '10000', '23.2; 23.49', 1, 1, 'all', '2014-11-27 01:52:38', NULL, NULL),
(NULL, 879, '413', 'Devitalisasi', '10000', '89.08; 89.31; 23.2', 1, 1, 'all', '2014-11-27 01:52:58', NULL, NULL),
(NULL, 880, '413', 'Pemberian Eugenol dan Tambalan Sementara', '10000', '23.70; 23.2', 1, 1, 'all', '2014-11-27 01:53:17', NULL, NULL),
(NULL, 881, '413', 'Scalling + Medikasi Oral', '10000', '89.31; 96.54', 1, 1, 'all', '2014-11-27 01:53:40', NULL, NULL),
(NULL, 882, '413', 'Medikasi Oral', '10000', '89.31; 24.99', 1, 1, 'all', '2014-11-27 01:54:21', NULL, NULL),
(NULL, 883, '413', 'Scalling', '10000', '96.54', 1, 1, 'all', '2014-11-27 01:54:40', NULL, NULL),
(NULL, 884, '413', 'Trepanasi + Medikasi Oral', '10000', '24.99; 23.70', 1, 1, 'all', '2014-11-27 01:55:38', NULL, NULL),
(NULL, 885, '413', 'Perawatan Endodontik', '10000', '23.09; 23.11', 1, 1, 'all', '2014-11-27 01:55:58', NULL, NULL),
(NULL, 886, '413', 'Tropical Fluor', '10000', '23.70; 23.2', 1, 1, 'all', '2014-11-27 01:56:54', NULL, NULL),
(NULL, 889, '413', 'Incisi + Medikasi Oral', '10000', '24.99; 24.00', 1, 1, 'all', '2014-11-27 01:58:05', NULL, NULL);
--
-- Indexes for dumped tables
--

--
-- Indexes for table `mst_icd`
--
DROP INDEX KD_ICD_INDUK ON mst_icd;

ALTER TABLE `mst_icd` DROP PRIMARY KEY,
 ADD PRIMARY KEY (`KD_PENYAKIT`,`KD_ICD_INDUK`), ADD KEY `KD_ICD_INDUK` (`KD_ICD_INDUK`);

--
-- Indexes for table `mst_produk`
--
ALTER TABLE `mst_produk` DROP PRIMARY KEY,
 ADD PRIMARY KEY (`KD_PRODUK`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `mst_produk`
--
-- ALTER TABLE `mst_produk`
-- MODIFY `KD_PRODUK` int(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=890;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `mst_icd`
--
-- ALTER TABLE mst_icd
-- DROP FOREIGN KEY mst_icd;

-- ALTER TABLE `mst_icd`
-- ADD CONSTRAINT `mst_icd_ibfk_1` FOREIGN KEY (`KD_ICD_INDUK`) REFERENCES `mst_icd_induk` (`KD_ICD_INDUK`) ON DELETE CASCADE ON UPDATE CASCADE;


drop procedure if exists AddColumnUnlessExists;
delimiter $$

create procedure AddColumnUnlessExists(
	IN dbName tinytext,
	IN tableName tinytext,
	IN fieldName tinytext,
	IN fieldDef text)
begin
	IF NOT EXISTS (
		SELECT * FROM information_schema.COLUMNS
		WHERE column_name=fieldName
		and table_name=tableName
		and table_schema=dbName
		)
	THEN
		set @ddl=CONCAT('ALTER TABLE ',dbName,'.',tableName,
			' ADD COLUMN ',fieldName,' ',fieldDef);
		prepare stmt from @ddl;
		execute stmt;
	END IF;
end$$

delimiter ;

-- drop procedure if exists AddColumnUnlessExists;

call AddColumnUnlessExists(Database(), 'pel_imunisasi', 'KD_PUSKESMAS', 'VARCHAR(20)');
call AddColumnUnlessExists(Database(), 'trans_imunisasi', 'KD_PUSKESMAS', 'VARCHAR(20)');
call AddColumnUnlessExists(Database(), 'apt_obat_terima', 'KD_KABUPATEN', 'VARCHAR(20)');
call AddColumnUnlessExists(Database(), 'apt_obat_keluar', 'KD_KABUPATEN', 'VARCHAR(20)');
call AddColumnUnlessExists(Database(), 'mst_icd', 'IS_ODONTOGRAM', 'TINYINT(1)');
call AddColumnUnlessExists(Database(), 'mst_produk', 'IS_ODONTOGRAM', 'TINYINT(1)');
call AddColumnUnlessExists(Database(), 'pel_ord_obat', 'KD_KABUPATEN', 'VARCHAR(20)');



 ALTER TABLE `family_folder` CHANGE `KD_FAMILY_FOLDER` `KD_FAMILY_FOLDER` INT(20) NOT NULL;



 CREATE TABLE IF NOT EXISTS `map_gigi_permukaan` (
`ID` int(11) NOT NULL,
  `ID_STATUS_GIGI` int(11) NOT NULL,
  `KD_GIGI_PERMUKAAN` int(11) DEFAULT NULL,
  `GAMBAR` varchar(200) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=321 ;

CREATE TABLE IF NOT EXISTS `mst_gigi` (
  `KD_GIGI` int(11) NOT NULL,
  `NAMA` varchar(100) NOT NULL,
  `GAMBAR` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `mst_gigi_permukaan` (
`KD_GIGI_PERMUKAAN` int(11) NOT NULL COMMENT 'ini ID Primary',
  `KODE` varchar(100) NOT NULL,
  `NAMA` varchar(100) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=38 ;

CREATE TABLE IF NOT EXISTS `mst_gigi_status` (
`ID_STATUS_GIGI` int(11) NOT NULL,
  `KD_STATUS_GIGI` varchar(100) NOT NULL,
  `JUMLAH_GIGI` int(11) DEFAULT '1' COMMENT 'Jumlah gigi untuk setiap status gigi',
  `DMF` varchar(20) DEFAULT NULL,
  `GAMBAR` varchar(200) NOT NULL,
  `STATUS` varchar(200) NOT NULL,
  `DESKRIPSI` text
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=46 ;

CREATE TABLE IF NOT EXISTS `t_foto_gigi_pasien` (
`KD_FOTO_GIGI` int(11) NOT NULL,
  `GAMBAR` varchar(200) NOT NULL,
  `TIPE_FOTO` int(11) NOT NULL COMMENT '1 = oral, 2 = x-ray',
  `TANGGAL` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `KD_PASIEN` varchar(100) NOT NULL,
  `KD_PUSKESMAS` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `t_perawatan_gigi_pasien` (
`ID` int(11) NOT NULL,
  `KD_GIGI` int(11) NOT NULL,
  `KD_MAP_GIGI` int(11) NOT NULL COMMENT 'table : map_gigi_permukaan',
  `KD_PENYAKIT` varchar(20) NOT NULL,
  `KD_ICD_INDUK` varchar(20) NOT NULL,
  `KD_PRODUK` int(20) NOT NULL,
  `KD_PASIEN` varchar(100) NOT NULL,
  `KD_DOKTER` varchar(20) NOT NULL,
  `KD_PETUGAS` varchar(20) NOT NULL,
  `KD_PUSKESMAS` varchar(100) NOT NULL,
  `AKAR_GIGI` int(11) DEFAULT NULL,
  `TANGGAL` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `NOTE` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;


INSERT INTO `mst_gigi_status` (`ID_STATUS_GIGI`, `KD_STATUS_GIGI`, `JUMLAH_GIGI`, `GAMBAR`, `STATUS`, `DESKRIPSI`) VALUES
(1, 'amf-b', 1, 'default4.png', 'Tambalan Amalgam Molar', NULL),
(2, 'amf-f', 1, 'default.png', 'Tambalan Amalgam Incisor', NULL),
(3, 'ano', 1, 'ano.png', 'Anomali / pegshaped, micro, fusi, etc', NULL),
(4, 'car', 1, 'default2.png', 'Caries = Tambalan sementara', NULL),
(5, 'cfr', 1, 'cfr.png', 'fracture', NULL),
(6, 'cof-b', 1, 'default6.png', 'Tambalan Composite Molar', NULL),
(7, 'cof-f', 1, 'default1.png', 'Tambalan Composite Incisor', NULL),
(8, 'fis-b', 1, 'default3.png', 'pit dan fissure sealant Molar', NULL),
(9, 'fis-f', 1, 'default5.png', 'pit dan fissure sealant Incisor', NULL),
(10, 'fmc', 1, 'fmc.png', 'Full metal crown pada gigi vital', NULL),
(11, 'fmc-rct', 1, 'fmc1.png', 'Full metal crown pada gigi non-vital', NULL),
(12, 'ipx-poc', 1, 'ipx-poc.png', 'Implant + Porcelain crown', NULL),
(13, 'meb', 3, 'meb1.png', 'Full metal cantilever bridge - 1', NULL),
(14, 'meb', 3, 'meb2.png', 'Full metal cantilever bridge - 2', NULL),
(15, 'meb', 3, 'meb3.png', 'Full metal cantilever bridge - 1', NULL),
(16, 'meb-pon', 3, 'meb-pon1.png', 'Full metal bridge 3 unit - 1', NULL),
(17, 'meb-pon', 3, 'meb-pon2.png', 'Full metal bridge 3 unit - 2', NULL),
(18, 'meb-pon', 3, 'meb-pon3.png', 'Full metal bridge 3 unit - 3', NULL),
(19, 'mig-rot-1', 1, 'mig-rot-1.png', 'Migrasi / Version / Rotasi', 'di buat panah sesuai arah'),
(20, 'mig-rot-10', 1, 'mig-rot-10.png', 'Migrasi / Version / Rotasi', NULL),
(21, 'mig-rot-11', 1, 'mig-rot-11.png', 'Migrasi / Version / Rotasi', NULL),
(22, 'mig-rot-12', 1, 'mig-rot-12.png', 'Migrasi / Version / Rotasi', NULL),
(23, 'mig-rot-2', 1, 'mig-rot-2.png', 'Migrasi / Version / Rotasi', NULL),
(24, 'mig-rot-3', 1, 'mig-rot-3.png', 'Migrasi / Version / Rotasi', NULL),
(25, 'mig-rot-4', 1, 'mig-rot-4.png', 'Migrasi / Version / Rotasi', NULL),
(26, 'mig-rot-5', 1, 'mig-rot-5.png', 'Migrasi / Version / Rotasi', NULL),
(27, 'mig-rot-6', 1, 'mig-rot-6.png', 'Migrasi / Version / Rotasi', NULL),
(28, 'mig-rot-7', 1, 'mig-rot-7.png', 'Migrasi / Version / Rotasi', NULL),
(29, 'mig-rot-8', 1, 'mig-rot-8.png', 'Migrasi / Version / Rotasi', NULL),
(30, 'mig-rot-9', 1, 'mig-rot-9.png', 'Migrasi / Version / Rotasi', NULL),
(31, 'mis', 1, 'mis.png', 'Gigi Hilang', NULL),
(32, 'non', 1, 'non.png', 'gigi tidak ada, tidak di ketahui ada atau tidak ada', NULL),
(33, 'nvt', 1, 'nvt.png', 'Gigi non-vital', NULL),
(34, 'pob', 4, 'pob1.png', 'Porcelain bridge 4 units - 1', NULL),
(35, 'pob', 4, 'pob2.png', 'Porcelain bridge 4 units - 2', NULL),
(36, 'pob', 4, 'pob21.png', 'Porcelain bridge 4 units - 3', NULL),
(37, 'pob', 4, 'pob4.png', 'Porcelain bridge 4 units - 4', NULL),
(38, 'poc', 1, 'poc.png', 'Porcelain crown pada gigi vital', NULL),
(39, 'poc-rct', 1, 'poc1.png', 'Porcelain crown pada gigi non vital', NULL),
(40, 'prd-fld', 1, 'prd_fld.png', 'Partial Denture / Full Denture', NULL),
(41, 'pre', 1, 'pre.png', 'Partial Erupt', NULL),
(42, 'rct', 1, 'back_ori.png', 'Perawatan saluran akar', NULL),
(43, 'rrx', 1, 'rrx.png', 'Sisa Akar', NULL),
(44, 'sou', 1, 'sou.png', 'Normal / Baik', NULL),
(45, 'une', 1, 'une.png', 'Un-Erupted', NULL);


INSERT INTO `mst_gigi_permukaan` (`KD_GIGI_PERMUKAAN`, `KODE`, `NAMA`) VALUES
(1, 'M', 'Mesial'),
(3, 'O', 'Occulus'),
(9, 'D', 'Distal'),
(10, 'V', 'Vestibular'),
(11, 'L', 'Lingual'),
(12, 'MO', 'Mesial Occusal'),
(13, 'MOD', 'Mesial Occusal Distal'),
(14, 'MODV', 'Mesial Occusal Distal Vestibular'),
(15, 'MODVL', 'Mesial Occusal Distal Vestibular Lingual'),
(16, 'OD', 'Occusal Distal'),
(17, 'ODV', 'Occusal Distal Vestibular'),
(18, 'ODVL', 'Occusal Distal Vestibular Lingual'),
(19, 'DV', 'Distal Vestibular'),
(20, 'DVL', 'Distal Vestibular Lingual'),
(21, 'VL', 'Vestibular Lingual'),
(22, 'MDVL', 'Mesial Distal Vestibular Lingual'),
(23, 'MOVL', 'Mesial Occusal Vestibular Lingual'),
(24, 'MODL', 'Mesial Occusal Distal Lingual'),
(25, 'MD', 'Mesial Distal'),
(26, 'MV', 'Mesial Vestibular'),
(27, 'ML', 'Mesial Lingual'),
(28, 'MOV', 'Mesial Occulus Vestibular'),
(29, 'MOL', 'Mesial Occulus Lingual'),
(30, 'MDV', 'Mesial Distal Vestibular'),
(31, 'MDL', 'Mesial Distal Lingual'),
(32, 'OV', 'Occulus Vestibular'),
(33, 'OL', 'Occulus Lingual'),
(34, 'ODL', 'Occulus Distal Lingual'),
(35, 'OVL', 'Occulus Vestibular Lingual'),
(36, 'DL', 'Distal Lingual'),
(37, 'MVL', 'Mesial Vestibular Lingual');


INSERT INTO `mst_gigi` (`KD_GIGI`, `NAMA`, `GAMBAR`) VALUES
(11, 'Central Incisor 1', 'normal_front_ori.png'),
(12, 'Lateral Incisor 1', 'normal_front_ori1.png'),
(13, 'Canine 1', 'normal_front_ori2.png'),
(14, 'First Premolar 1', 'normal_back_ori3.png'),
(15, 'Second Premolar 1', 'normal_back_ori4.png'),
(16, 'First Molar 1', 'normal_back_ori5.png'),
(17, 'Second Molar 1', 'normal_back_ori6.png'),
(18, 'Third Molar 1', 'normal_back_ori7.png'),
(21, 'Central Incisor 2', 'normal_front_ori3.png'),
(22, 'Lateral Incisor 2', 'normal_front_ori4.png'),
(23, 'Canine 2', 'normal_front_ori5.png'),
(24, 'First Premolar 2', 'normal_back_ori.png'),
(25, 'Second Premolar 2', 'normal_back_ori1.png'),
(26, 'First Molar 2', 'normal_back_ori2.png'),
(27, 'Second Molar 2', 'normal_back_ori8.png'),
(28, 'Third Molar 2', 'normal_back_ori9.png'),
(31, 'Central Incisor 3', 'normal_front_ori6.png'),
(32, 'Lateral Incisor 3', 'normal_front_ori7.png'),
(33, 'Canine 3', 'normal_front_ori8.png'),
(34, 'First Premolar 3', 'normal_back_ori10.png'),
(35, 'Second Premolar 3', 'normal_back_ori11.png'),
(36, 'First Molar 3', 'normal_back_ori12.png'),
(37, 'Second Molar 3', 'normal_back_ori13.png'),
(38, 'Third Molar 3', 'normal_back_ori14.png'),
(41, 'Central Incisor', 'normal_front_ori9.png'),
(42, 'Lateral Incisor 4', 'normal_front_ori10.png'),
(43, 'Canine 4', 'normal_front_ori11.png'),
(44, 'First Premolar 4', 'normal_back_ori15.png'),
(45, 'Second Premolar 4', 'normal_back_ori16.png'),
(46, 'First Molar 4', 'normal_back_ori17.png'),
(47, 'Second Molar 4', 'normal_back_ori18.png'),
(48, 'Third Molar 4', 'normal_back_ori19.png'),
(51, 'Central Incisor 5', 'normal_front_ori12.png'),
(52, 'Lateral Incisor 5', 'normal_front_ori13.png'),
(53, 'Canine 5', 'normal_front_ori14.png'),
(54, 'First Molar 5', 'normal_back_ori20.png'),
(55, 'Second Molar 5', 'normal_back_ori21.png'),
(61, 'Central Incisor 6', 'normal_front_ori15.png'),
(62, 'Lateral Incisor 6', 'normal_front_ori16.png'),
(63, 'Canine 6', 'normal_front_ori19.png'),
(64, 'First Molar 6', 'normal_back_ori27.png'),
(65, 'Second Molar 6', 'normal_back_ori26.png'),
(71, 'Central Incisor 7', 'normal_front_ori21.png'),
(72, 'Lateral Incisor 7', 'normal_front_ori23.png'),
(73, 'Canine 7', 'normal_front_ori22.png'),
(74, 'First Molar 7', 'normal_back_ori25.png'),
(75, 'Second Molar 7', 'normal_back_ori24.png'),
(81, 'Central Incisor 8', 'normal_front_ori20.png'),
(82, 'Lateral Incisor 8', 'normal_front_ori18.png'),
(83, 'Canine 8', 'normal_front_ori17.png'),
(84, 'First Molar 8', 'normal_back_ori23.png'),
(85, 'Second Molar 8', 'normal_back_ori22.png');


INSERT INTO `map_gigi_permukaan` (`ID`, `ID_STATUS_GIGI`, `KD_GIGI_PERMUKAAN`, `GAMBAR`) VALUES
(87, 2, NULL, 'default.png'),
(88, 7, NULL, 'default1.png'),
(109, 33, NULL, 'nvt.png'),
(110, 42, NULL, 'back_ori.png'),
(111, 32, NULL, 'non.png'),
(112, 45, NULL, 'une.png'),
(113, 41, NULL, 'pre.png'),
(114, 44, NULL, 'sou.png'),
(115, 3, NULL, 'ano.png'),
(116, 4, NULL, 'default2.png'),
(117, 5, NULL, 'cfr.png'),
(118, 8, NULL, 'default3.png'),
(119, 10, NULL, 'fmc.png'),
(120, 11, NULL, 'fmc1.png'),
(121, 38, NULL, 'poc.png'),
(122, 39, NULL, 'poc1.png'),
(123, 43, NULL, 'rrx.png'),
(124, 31, NULL, 'mis.png'),
(125, 12, NULL, 'ipx-poc.png'),
(126, 16, NULL, 'meb-pon1.png'),
(127, 17, NULL, 'meb-pon2.png'),
(128, 18, NULL, 'meb-pon3.png'),
(129, 34, NULL, 'pob1.png'),
(130, 35, NULL, 'pob2.png'),
(131, 36, NULL, 'pob21.png'),
(132, 37, NULL, 'pob4.png'),
(133, 13, NULL, 'meb1.png'),
(134, 14, NULL, 'meb2.png'),
(135, 15, NULL, 'meb3.png'),
(136, 40, NULL, 'prd_fld.png'),
(137, 19, NULL, 'mig-rot-1.png'),
(138, 23, NULL, 'mig-rot-2.png'),
(139, 24, NULL, 'mig-rot-3.png'),
(140, 25, NULL, 'mig-rot-4.png'),
(141, 26, NULL, 'mig-rot-5.png'),
(142, 27, NULL, 'mig-rot-6.png'),
(143, 28, NULL, 'mig-rot-7.png'),
(144, 29, NULL, 'mig-rot-8.png'),
(145, 30, NULL, 'mig-rot-9.png'),
(146, 20, NULL, 'mig-rot-10.png'),
(147, 21, NULL, 'mig-rot-11.png'),
(148, 22, NULL, 'mig-rot-12.png'),
(149, 4, 9, 'caries_d.png'),
(150, 4, 11, 'caries_l.png'),
(151, 4, 1, 'caries_m.png'),
(152, 4, 3, 'caries_o.png'),
(153, 4, 10, 'caries_v.png'),
(154, 4, 36, 'caries_dl.png'),
(155, 4, 19, 'caries_dv.png'),
(156, 4, 25, 'caries_md.png'),
(157, 4, 27, 'caries_ml.png'),
(158, 4, 12, 'caries_mo.png'),
(159, 4, 26, 'caries_mv.png'),
(160, 4, 16, 'caries_od.png'),
(161, 4, 33, 'caries_ol.png'),
(162, 4, 32, 'caries_ov.png'),
(163, 4, 21, 'caries_vl.png'),
(164, 4, 20, 'caries_dvl.png'),
(165, 4, 31, 'caries_mdl.png'),
(166, 4, 30, 'caries_mdv.png'),
(167, 4, 13, 'caries_mod.png'),
(168, 4, 29, 'caries_mol.png'),
(169, 4, 28, 'caries_mov.png'),
(170, 4, 37, 'caries_mvl.png'),
(171, 4, 34, 'caries_odl.png'),
(172, 4, 17, 'caries_odv.png'),
(173, 4, 35, 'caries_ovl.png'),
(174, 4, 22, 'caries_mdvl.png'),
(175, 4, 24, 'caries_modl.png'),
(176, 4, 14, 'caries_modv.png'),
(177, 4, 23, 'caries_movl.png'),
(178, 4, 18, 'caries_odvl.png'),
(179, 4, 15, 'caries_modvl.png'),
(180, 1, NULL, 'default4.png'),
(181, 1, 9, 'amf_b_d.png'),
(182, 1, 11, 'amf_b_l.png'),
(183, 1, 1, 'amf_b_m.png'),
(184, 1, 3, 'amf_b_o.png'),
(185, 1, 10, 'amf_b_v.png'),
(186, 1, 36, 'amf_b_dl.png'),
(187, 1, 19, 'amf_b_dv.png'),
(188, 1, 25, 'amf_b_md.png'),
(189, 1, 27, 'amf_b_ml.png'),
(190, 1, 12, 'amf_b_mo.png'),
(191, 1, 26, 'amf_b_mv.png'),
(192, 1, 16, 'amf_b_od.png'),
(193, 1, 33, 'amf_b_ol.png'),
(194, 1, 32, 'amf_b_ov.png'),
(195, 1, 21, 'amf_b_vl.png'),
(196, 1, 20, 'amf_b_dvl.png'),
(197, 1, 31, 'amf_b_mdl.png'),
(198, 1, 30, 'amf_b_mdv.png'),
(199, 1, 13, 'amf_b_mod.png'),
(200, 1, 29, 'amf_b_mol.png'),
(201, 1, 28, 'amf_b_mov.png'),
(202, 1, 37, 'amf_b_mvl.png'),
(203, 1, 34, 'amf_b_odl.png'),
(204, 1, 17, 'amf_b_odv.png'),
(205, 1, 35, 'amf_b_ovl.png'),
(206, 1, 15, 'amf_b_modvl.png'),
(207, 1, 22, 'amf_b_mdvl.png'),
(208, 1, 24, 'amf_b_modl.png'),
(209, 1, 14, 'mamf_b_modv.png'),
(210, 1, 23, 'amf_b_movl.png'),
(211, 1, 18, 'amf_b_odvl.png'),
(212, 2, 9, 'amf_f_d.png'),
(213, 2, 11, 'amf_f_l.png'),
(214, 2, 1, 'amf_f_m.png'),
(215, 2, 10, 'amf_f_v.png'),
(216, 2, 36, 'amf_f_dl.png'),
(217, 2, 19, 'amf_f_dv.png'),
(218, 2, 25, 'amf_f_md.png'),
(219, 2, 27, 'amf_f_ml.png'),
(220, 2, 26, 'amf_f_mv.png'),
(221, 2, 21, 'amf_f_vl.png'),
(222, 2, 20, 'amf_f_dvl.png'),
(223, 2, 31, 'amf_f_mdl.png'),
(224, 2, 30, 'amf_f_mdv.png'),
(225, 2, 37, 'amf_f_mvl.png'),
(226, 2, 22, 'amf_f_mdvl.png'),
(227, 9, NULL, 'default5.png'),
(228, 6, NULL, 'default6.png'),
(229, 8, 9, 'fis_b_d.png'),
(230, 8, 11, 'fis_b_l.png'),
(231, 8, 1, 'fis_b_m.png'),
(232, 8, 3, 'fis_b_o.png'),
(233, 8, 10, 'fis_b_v.png'),
(234, 8, 36, 'fis_b_dl.png'),
(235, 8, 19, 'fis_b_dv.png'),
(236, 8, 25, 'fis_b_md.png'),
(237, 8, 27, 'fis_b_ml.png'),
(238, 8, 12, 'fis_b_mo.png'),
(239, 8, 26, 'fis_b_mv.png'),
(240, 8, 16, 'fis_b_od.png'),
(241, 8, 33, 'fis_b_ol.png'),
(242, 8, 32, 'fis_b_ov.png'),
(243, 8, 21, 'fis_b_vl.png'),
(244, 8, 20, 'fis_b_dvl.png'),
(245, 8, 31, 'fis_b_mdl.png'),
(246, 8, 30, 'fis_b_mdv.png'),
(247, 8, 13, 'fis_b_mod.png'),
(248, 8, 29, 'fis_b_mol.png'),
(249, 8, 28, 'fis_b_mov.png'),
(250, 8, 37, 'fis_b_mvl.png'),
(251, 8, 34, 'fis_b_odl.png'),
(252, 8, 17, 'fis_b_odv.png'),
(253, 8, 35, 'fis_b_ovl.png'),
(254, 8, 15, 'fis_b_modvl.png'),
(255, 8, 22, 'fis_b_mdvl.png'),
(256, 8, 24, 'fis_b_modl.png'),
(257, 8, 14, 'fis_b_modv.png'),
(258, 8, 23, 'fis_b_movl.png'),
(259, 8, 18, 'fis_b_odvl.png'),
(260, 9, 9, 'fis_f_d.png'),
(261, 9, 11, 'fis_f_l.png'),
(262, 9, 1, 'fis_f_m.png'),
(263, 9, 10, 'fis_f_v.png'),
(264, 9, 36, 'fis_f_dl.png'),
(265, 9, 19, 'fis_f_dv.png'),
(266, 9, 25, 'fis_f_md.png'),
(267, 9, 27, 'fis_f_ml.png'),
(268, 9, 26, 'fis_f_mv.png'),
(269, 9, 21, 'fis_f_vl.png'),
(270, 9, 20, 'fis_f_dvl.png'),
(271, 9, 31, 'fis_f_mdl.png'),
(272, 9, 30, 'fis_f_mdv.png'),
(273, 9, 37, 'fis_f_mvl.png'),
(274, 9, 22, 'fis_f_mdvl.png'),
(275, 6, 9, 'cof_b_d.png'),
(276, 6, 11, 'cof_b_l.png'),
(277, 6, 1, 'cof_b_m.png'),
(278, 6, 3, 'cof_b_o.png'),
(279, 6, 10, 'cof_b_v.png'),
(280, 6, 36, 'cof_b_dl.png'),
(281, 6, 19, 'cof_b_dv.png'),
(282, 6, 25, 'cof_b_md.png'),
(283, 6, 27, 'cof_b_ml.png'),
(284, 6, 12, 'cof_b_mo.png'),
(285, 6, 26, 'cof_b_mv.png'),
(286, 6, 16, 'cof_b_od.png'),
(287, 6, 33, 'cof_b_ol.png'),
(288, 6, 32, 'cof_b_ov.png'),
(289, 6, 21, 'cof_b_vl.png'),
(290, 6, 20, 'cof_b_dvl.png'),
(291, 6, 31, 'cof_b_mdl.png'),
(292, 6, 30, 'cof_b_mdv.png'),
(293, 6, 13, 'cof_b_mod.png'),
(294, 6, 29, 'cof_b_mol.png'),
(295, 6, 28, 'cof_b_mov.png'),
(296, 6, 37, 'cof_b_mvl.png'),
(297, 6, 34, 'cof_b_odl.png'),
(298, 6, 17, 'cof_b_odv.png'),
(299, 6, 35, 'cof_b_ovl.png'),
(300, 6, 22, 'cof_b_mdvl.png'),
(301, 6, 24, 'cof_b_modl.png'),
(302, 6, 14, 'cof_b_modv.png'),
(303, 6, 23, 'cof_b_movl.png'),
(304, 6, 18, 'cof_b_odvl.png'),
(305, 6, 15, 'cof_b_modvl.png'),
(306, 7, 9, 'cof_f_d.png'),
(307, 7, 11, 'cof_f_l.png'),
(308, 7, 1, 'cof_f_m.png'),
(309, 7, 10, 'cof_f_v.png'),
(310, 7, 36, 'cof_f_dl.png'),
(311, 7, 19, 'cof_f_dv.png'),
(312, 7, 25, 'cof_f_md.png'),
(313, 7, 27, 'cof_f_ml.png'),
(314, 7, 26, 'cof_f_mv.png'),
(315, 7, 21, 'cof_f_vl.png'),
(316, 7, 20, 'cof_f_dvl.png'),
(317, 7, 31, 'cof_f_mdl.png'),
(318, 7, 30, 'cof_f_mdv.png'),
(319, 7, 37, 'cof_f_mvl.png'),
(320, 7, 22, 'cof_f_mdvl.png');



ALTER TABLE `map_gigi_permukaan`
 ADD PRIMARY KEY (`ID`), ADD KEY `KD_GIGI_PERMUKAAN` (`KD_GIGI_PERMUKAAN`), ADD KEY `ID_STATUS_GIGI` (`ID_STATUS_GIGI`);

ALTER TABLE `mst_gigi`
 ADD PRIMARY KEY (`KD_GIGI`);

ALTER TABLE `mst_gigi_permukaan`
 ADD PRIMARY KEY (`KD_GIGI_PERMUKAAN`);

ALTER TABLE `mst_gigi_status`
 ADD PRIMARY KEY (`ID_STATUS_GIGI`);

ALTER TABLE `t_foto_gigi_pasien`
 ADD PRIMARY KEY (`KD_FOTO_GIGI`);

ALTER TABLE `t_perawatan_gigi_pasien`
 ADD PRIMARY KEY (`ID`), ADD KEY `KD_GIGI` (`KD_GIGI`), ADD KEY `KD_STATUS_GIGI` (`KD_MAP_GIGI`), ADD KEY `KD_PASIEN` (`KD_PASIEN`), ADD KEY `KD_DOKTER` (`KD_DOKTER`), ADD KEY `KD_PUSKESMAS` (`KD_PUSKESMAS`), ADD KEY `KD_ICD_INDUK` (`KD_ICD_INDUK`), ADD KEY `KD_PRODUK` (`KD_PRODUK`), ADD KEY `fk_icd_perawatan_gigi` (`KD_PENYAKIT`,`KD_ICD_INDUK`);

ALTER TABLE `map_gigi_permukaan`
ADD CONSTRAINT `map_gigi_permukaan_ibfk_1` FOREIGN KEY (`KD_GIGI_PERMUKAAN`) REFERENCES `mst_gigi_permukaan` (`KD_GIGI_PERMUKAAN`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `map_gigi_permukaan_ibfk_2` FOREIGN KEY (`ID_STATUS_GIGI`) REFERENCES `mst_gigi_status` (`ID_STATUS_GIGI`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `t_perawatan_gigi_pasien`
ADD CONSTRAINT `fk_icd_tindakan_gigi` FOREIGN KEY (`KD_PRODUK`) REFERENCES `mst_produk` (`KD_PRODUK`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `fk_icd_perawatan_gigi` FOREIGN KEY (`KD_PENYAKIT`, `KD_ICD_INDUK`) REFERENCES `mst_icd` (`KD_PENYAKIT`, `KD_ICD_INDUK`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `t_perawatan_gigi_pasien_ibfk_1` FOREIGN KEY (`KD_GIGI`) REFERENCES `mst_gigi` (`KD_GIGI`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `t_perawatan_gigi_pasien_ibfk_2` FOREIGN KEY (`KD_MAP_GIGI`) REFERENCES `map_gigi_permukaan` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;


 SET FOREIGN_KEY_CHECKS=1;
