CREATE TABLE T_energie
(
	e_id_energie		INT		PRIMARY KEY AUTO_INCREMENT,
	e_description		varchar(100)	NOT NULL
)ENGINE=InnoDB  DEFAULT CHARSET=utf8;

CREATE TABLE T_typeMaison
(
	t_type			INT		PRIMARY KEY AUTO_INCREMENT,
	t_description 		varchar(2)	NOT NULL
)ENGINE=InnoDB  DEFAULT CHARSET=utf8;

CREATE TABLE T_photo
(
	p_idphoto		INT 		PRIMARY KEY AUTO_INCREMENT,
	p_titre			varchar(100)	NOT NULL,
	p_nom			varchar(100)	NOT NULL 
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE T_utilisateur
(
	u_id			INT		PRIMARY KEY AUTO_INCREMENT,
	u_mail			varchar(255)	NOT NULL UNIQUE,
	u_mdp			varchar(100)	NOT NULL,
	u_pseudo		varchar(30)	NOT NULL UNIQUE,
	u_nom			varchar(30)	NOT NULL,
	u_prenom		varchar(30)	NOT NULL
)ENGINE=InnoDB  DEFAULT CHARSET=utf8;

CREATE TABLE T_annonce
(
	id_annonce		INT 		PRIMARY KEY AUTO_INCREMENT,
	titre 			varchar(255)	NOT NULL,
	cout_loyer		real		NOT NULL,	
	cout_charges		real		NOT NULL,		
	type_chauffage		varchar(100)	NOT NULL,		
	superficie		int		NOT NULL,
	description 		varchar(255)	NOT NULL,
	adresse			varchar(255)	NOT NULL, 
	ville			varchar(255)	NOT NULL,
	cp			decimal(5)	NOT NULL,
	etat_annonce 		varchar(20)	NOT NULL, 
	e_id_energie 		INT		NOT NULL,
	p_idphoto		INT		NOT NULL,
	T_type          	INT		NOT NULL,
	u_id			INT		NOT NULL,
	constraint FK_annonce_energie foreign key (e_id_energie) references T_energie(e_id_energie), 
	constraint FK_annonce_photo foreign key (p_idphoto) references T_photo(p_idphoto), 
	constraint FK_annonce_typemaison foreign key (t_type) references T_typeMaison(t_type),
	constraint FK_annonce_iduser foreign key (u_id) references T_utilisateur(u_id) ON DELETE CASCADE ON UPDATE CASCADE

)ENGINE=InnoDB  DEFAULT CHARSET=utf8;


CREATE TABLE T_message
(
	id_annonce			INT		NOT NULL, 
	u_mail				varchar(255)	NOT NULL, 
	m_dateheure_message		TIMESTAMP	NOT NULL, 
	m_texte_message			varchar(255)	NOT NULL,
	
	primary key(id_annonce,u_mail),
	constraint FK_message_utilisateur foreign key (u_mail) references T_utilisateur(u_mail) ON DELETE CASCADE,
	constraint FK_message_annonce foreign key(id_annonce) references T_annonce(id_annonce) ON DELETE CASCADE
)ENGINE=InnoDB  DEFAULT CHARSET=utf8;

INSERT INTO T_utilisateur VALUES (1,'root@gmail.com','root','Admin','Root','Root');

INSERT INTO T_energie VALUES (1,'Fioul');
INSERT INTO T_energie VALUES (DEFAULT,'Electricité');
INSERT INTO T_energie VALUES (DEFAULT,'Gaz');

INSERT INTO T_typeMaison VALUES (1,'T1');
INSERT INTO T_typeMaison VALUES (DEFAULT,'T2');
INSERT INTO T_typeMaison VALUES (DEFAULT,'T3');
INSERT INTO T_typeMaison VALUES (DEFAULT,'T4');
INSERT INTO T_typeMaison VALUES (DEFAULT,'T5');
INSERT INTO T_typeMaison VALUES (DEFAULT,'T6');

INSERT INTO T_photo VALUES (1,'test','root');

INSERT INTO T_annonce VALUES (1,'Appart à 5 min de l IUT',450,50,'electrique',25,'appart à louer dans une résidence à côté de l''iut','26 bis rue mireille','Arles',13200,'publier',1,1,1,1);
INSERT INTO T_annonce VALUES (DEFAULT,'Chambre dans une maison',450,50,'electrique',50,'chambre à louer dans une maison','26 rue mireille','Arles',13200,'publier',1,1,1,1);																				
INSERT INTO T_annonce VALUES (DEFAULT,'Appartement centre ville',450,50,'electrique',60,'appartement situé en centre ville, 15 min iut','4 rue du 11 septembre','Arles',13200,'publier',1,1,1,1);
INSERT INTO T_annonce VALUES (DEFAULT,'Appart de l autre coté du Rhône',500,70,'electrique',70,'appartement situé de l''côté du Rhône','9 Rue Charles Moron','Arles',13200,'publier',1,1,1,1);
INSERT INTO T_annonce VALUES (DEFAULT,'Maison',450,50,'electrique',60,'appartement situé en centre ville, 15 min iut','4 rue du 11 septembre','Arles',13200,'publier',1,1,1,1);
INSERT INTO T_annonce VALUES (DEFAULT,'Appartement près des Arènes',500,70,'electrique',70,'appartement situé de l''côté du Rhône','9 Rue Georges Trezeguet','Arles',13200,'publier',1,1,1,1);
INSERT INTO T_annonce VALUES (DEFAULT,'Appartement en face de la tour Luma',450,50,'electrique',60,'appartement situé en centre ville, 15 min iut','10 rue du 11 septembre','Arles',13200,'publier',1,1,1,1);
INSERT INTO T_annonce VALUES (DEFAULT,'Appartement coté de Tarascon',500,70,'electrique',70,'appartement situé de l''côté du Rhône','15 Rue Charles Zigzag','Arles',13200,'publier',1,1,1,1);



