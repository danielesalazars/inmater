/************************************************
* DNI for test : 40716301
*************************************************/

/************************************************
* New Table for Medicines 
*************************************************/
CREATE TABLE `hc_agenda`(
  `id` int(11) NOT NULL,
  `dni` char(15) NOT NULL,
  `medi_name` varchar(100) NOT NULL,
  `medi_dosis` varchar(100),
  `medi_frecuencia` int(2),
  `medi_cant_dias` int(2),
  `medi_init_fec` date,
  `medi_init_h` char(2),
  `medi_init_m` char(2),
  `medi_obs` varchar(200),
  FOREIGN KEY (`id`) REFERENCES `hc_gineco`(`id`),
  FOREIGN KEY (`dni`) REFERENCES `hc_paciente`(`dni`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/************************************************
* Insert for test hc_agenda
*************************************************/
INSERT INTO `hc_agenda` (`id`, `dni`, `medi_name`, `medi_dosis`, `medi_frecuencia`, 
`medi_cant_dias`, `medi_init_fec`, `medi_init_h`, `medi_init_m`, `medi_obs`) 
VALUES (269, 40716301, 'medicamento de ejemplo', '1 tableta', 8, 5, '2016-11-23', '23', '05', 'No obs');

/************************************************
* Query for test Login
*************************************************/
SELECT dni,nom,ape,mai FROM hc_paciente WHERE dni='40716301' and pass='40716301';

/************************************************
* Query for test Update Password
*************************************************/
UPDATE hc_paciente SET pass='myPass' where dni='40716301' and pass='40716301'

/************************************************
* Query for test get Appointments
*************************************************/
SELECT id, fec, fec_h, fec_m, mot from hc_gineco where dni = '40716301';

/************************************************
* Query for test get Medicines
*************************************************/
SELECT id, medi_name, medi_dosis, medi_frecuencia, medi_cant_dias, medi_init_fec, medi_init_h, 
       medi_init_m, medi_obs from hc_agenda where dni = '40716301';

/************************************************
* Insert for test hc_gineco
*************************************************/
INSERT INTO `hc_gineco` (`id`, `dni`, `fec`, `med`, `fec_h`, `fec_m`, `mot`, `dig`, `medi`, `aux`, `efec`, `cic`, `vag`, `vul`, `cer`, `cer1`, `mam`, `mam1`, `t_vag`, `eco`, `e_sol`, `i_med`, `i_fec`, `i_obs`, `in_t`, `in_f1`, `in_h1`, `in_m1`, `in_f2`, `in_h2`, `in_m2`, `in_c`) VALUES 
(3191, '40716301', '2016-11-25', 'mvelit', '04', '07', 'CONSULTA', '', '', '', '2016-11-24', NULL, '', '', '', '', '', '', '', '', '', 0, '2016-11-24', '', '', '2016-11-24', '', '', '2016-11-24', '', '', 0);











