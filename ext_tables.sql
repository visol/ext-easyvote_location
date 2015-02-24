#
# Table structure for table 'tx_easyvotelocation_domain_model_location'
#
CREATE TABLE tx_easyvotelocation_domain_model_location (

	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,

	location_type int(11) unsigned DEFAULT '0',
	name varchar(255) DEFAULT '' NOT NULL,
	address varchar(255) DEFAULT '' NOT NULL,
	longitude double(11,2) DEFAULT '0.00' NOT NULL,
	latitude double(11,2) DEFAULT '0.00' NOT NULL,
	city varchar(255) DEFAULT '' NOT NULL,
	creator varchar(255) DEFAULT '' NOT NULL,
	last_updater varchar(255) DEFAULT '' NOT NULL,
	description text NOT NULL,
	is_available_for_current_voting_day varchar(255) DEFAULT '' NOT NULL,
	photo int(11) unsigned NOT NULL default '0',

	street varchar(255) DEFAULT '' NOT NULL,
	zip varchar(12) DEFAULT '' NOT NULL,
	city varchar(64) DEFAULT '' NOT NULL,
	canton varchar(12) DEFAULT '' NOT NULL,
	import_id varchar(64) DEFAULT '' NOT NULL,
	emptying_time_day_1 varchar(12) DEFAULT '' NOT NULL,
	emptying_time_day_2 varchar(12) DEFAULT '' NOT NULL,
	emptying_time_day_3 varchar(12) DEFAULT '' NOT NULL,
	emptying_time_day_4 varchar(12) DEFAULT '' NOT NULL,
	emptying_time_day_5 varchar(12) DEFAULT '' NOT NULL,
	emptying_time_day_6 varchar(12) DEFAULT '' NOT NULL,
	emptying_time_day_7 varchar(12) DEFAULT '' NOT NULL,

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
	KEY import_id (import_id),
	KEY zip (zip),
	KEY city (city),

 KEY language (l10n_parent,sys_language_uid)

);

#
# Table structure for table 'tx_easyvotelocation_domain_model_locationtype'
#
CREATE TABLE tx_easyvotelocation_domain_model_locationtype (

	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,

	name varchar(255) DEFAULT '' NOT NULL,
	icon int(11) unsigned NOT NULL default '0',
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
