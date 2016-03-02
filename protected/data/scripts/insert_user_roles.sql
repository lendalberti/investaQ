INSERT INTO user_roles(user_id,role_id) VALUES(1,1);  -- Admin, me


-- 1 Assembly: Jamie Vatcher, Chuck Shermer, Trevor Pounder
-- 2 Test: Pete Crudele, Gary Francouer
-- 3 Quality: Steve Lombard, Bob Buchanon, Steve Herschfeld


--  id | user_id | role_id | bto_group_id 

INSERT INTO user_roles(user_id,role_id) VALUES(2,5);  -- Proposal Manager, Mike Kelleher
INSERT INTO user_roles(user_id,role_id) VALUES(3,2);  -- User,             Emily Elie
INSERT INTO user_roles(user_id,role_id) VALUES(4,4);  -- Approver,         Bob Wiles

INSERT INTO user_roles(user_id,role_id, bto_group_id) VALUES(5,6,   1 );  -- BTO Approver,     jvatcher
INSERT INTO user_roles(user_id,role_id, bto_group_id) VALUES(6,6,   1 );  -- BTO Approver,     cshermer
INSERT INTO user_roles(user_id,role_id, bto_group_id) VALUES(7,6,   1 );  -- BTO Approver,     tpounder

INSERT INTO user_roles(user_id,role_id, bto_group_id) VALUES(8,6,   2 );  -- BTO Approver,     pcrudele
INSERT INTO user_roles(user_id,role_id, bto_group_id) VALUES(9,6,   2 );  -- BTO Approver,     gfrancoeur

INSERT INTO user_roles(user_id,role_id, bto_group_id) VALUES(11,6,  3 );  -- BTO Approver,     slombard
INSERT INTO user_roles(user_id,role_id, bto_group_id) VALUES(12,6,  3 );  -- BTO Approver,     bbuchanon
INSERT INTO user_roles(user_id,role_id, bto_group_id) VALUES(13,6,  3 );  -- BTO Approver,     shirschfeld

