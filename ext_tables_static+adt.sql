DROP TABLE IF EXISTS tx_easyvotelocation_domain_model_locationtype;
CREATE TABLE tx_easyvotelocation_domain_model_locationtype (

	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,

	name varchar(255) DEFAULT '' NOT NULL,
	description text NOT NULL,
	is_content_editable tinyint(1) unsigned DEFAULT '0' NOT NULL,
	locations int(11) unsigned DEFAULT '0' NOT NULL,

	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
	deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
	hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,

	sys_language_uid int(11) DEFAULT '0' NOT NULL,
	l10n_parent int(11) DEFAULT '0' NOT NULL,
	l10n_diffsource mediumblob,

	PRIMARY KEY (uid),
	KEY parent (pid),

 KEY language (l10n_parent,sys_language_uid)

);

INSERT INTO tx_easyvotelocation_domain_model_locationtype VALUES (1,	0,	'Briefkasten',	'',	0,	0,	1424700256,	1424700256,	12,	0,	0,	0,	0,	NULL);
INSERT INTO tx_easyvotelocation_domain_model_locationtype VALUES (2,	0,	'Gemeindeverwaltung',	'',	1,	0,	1424700315,	1424700315,	12,	0,	0,	0,	0,	NULL);
INSERT INTO tx_easyvotelocation_domain_model_locationtype VALUES (3,	0,	'Wahllokal',	'',	0,	0,	1424702087,	1424702087,	12,	0,	0,	0,	0,	NULL);
INSERT INTO tx_easyvotelocation_domain_model_locationtype VALUES (4,	0,	'Boîte aux lettres',	'',	0,	0,	1429028816,	1429028802,	12,	0,	0,	1,	1,	NULL);
INSERT INTO tx_easyvotelocation_domain_model_locationtype VALUES (5,	0,	'Bucalettere',	'',	0,	0,	1429084530,	1429028819,	12,	0,	0,	2,	1,	NULL);
INSERT INTO tx_easyvotelocation_domain_model_locationtype VALUES (6,	0,	'Administration communale',	'',	1,	0,	1429084545,	1429028839,	12,	0,	0,	1,	2,	NULL);
INSERT INTO tx_easyvotelocation_domain_model_locationtype VALUES (7,	0,	'Amministrazione comunale',	'',	1,	0,	1429084596,	1429028853,	12,	0,	0,	2,	2,	NULL);
INSERT INTO tx_easyvotelocation_domain_model_locationtype VALUES (8,	0,	'Bureau de vote',	'',	0,	0,	1429028866,	1429028860,	12,	0,	0,	1,	3,	NULL);
INSERT INTO tx_easyvotelocation_domain_model_locationtype VALUES (9,	0,	'Ufficio elettorale',	'',	0,	0,	1429084625,	1429028868,	12,	0,	0,	2,	3,	NULL);
INSERT INTO tx_easyvotelocation_domain_model_locationtype VALUES (10,	0,	'#VoteNow2015',	'',	0,	0,	1424700256,	1424700256,	12,	0,	0,	0,	0,	NULL);
INSERT INTO tx_easyvotelocation_domain_model_locationtype VALUES (11,	0,	'#VoteNow2015',	'',	0,	0,	1424700256,	1424700256,	12,	0,	0,	1,	10,	NULL);
INSERT INTO tx_easyvotelocation_domain_model_locationtype VALUES (12,	0,	'#VoteNow2015',	'',	0,	0,	1424700256,	1424700256,	12,	0,	0,	2,	10,	NULL);
