-- Add module to `ohrm_module` table
INSERT INTO ohrm_module (name, status) VALUES
('claim', '1');
set @module_id := (SELECT id FROM ohrm_module WHERE name = 'claim');
set @admin_role_id := (SELECT id FROM ohrm_user_role WHERE name = 'Admin');
set @ESS_role_id := (SELECT id FROM ohrm_user_role WHERE name = 'ESS');
set @Supervisor_role_id := (SELECT id FROM ohrm_user_role WHERE name = 'Supervisor');

-- Add screens to `ohrm_screen` table
INSERT INTO ohrm_screen (name, module_id, action_url) VALUES
('Configuration', @module_id , NULL),
('Event', @module_id , 'viewEvent'),
('Expense Types', @module_id , 'viewExpense'),
('Employee Claim List', @module_id , 'viewAssignClaim'),
('Assign Claim', @module_id , 'assignClaim'),
('Submit Claim', @module_id , 'submitClaim'),
('My Claims List', @module_id , 'viewClaim');

-- set screens id
set @claim_event_screen_id := (SELECT id FROM ohrm_screen WHERE action_url = 'viewEvent');
set @claim_expense_type_screen_id := (SELECT id FROM ohrm_screen WHERE action_url = 'viewExpense');
set @claim_employee_claim_list_screen_id := (SELECT id FROM ohrm_screen WHERE action_url = 'viewAssignClaim');
set @claim_assign_claim_screen_id := (SELECT id FROM ohrm_screen WHERE action_url = 'assignClaim');
set @submit_claim_screen_id := (SELECT id FROM ohrm_screen WHERE action_url = 'submitClaim');
set @self_claims_list_screen_id := (SELECT id FROM ohrm_screen WHERE action_url = 'viewClaim');

-- Add menu items to `ohrm_menu_items` which are showing in UI left menu
INSERT INTO ohrm_menu_item (menu_title, screen_id, parent_id, level, order_hint, url_extras, status) VALUES

('Claim', NULL , NULL, '1', '1300', NULL, '1');

set @parent_menu_id := (SELECT id FROM ohrm_menu_item WHERE menu_title = 'Claim');

INSERT INTO ohrm_menu_item (menu_title, screen_id, parent_id, level, order_hint, url_extras, status) VALUES
('Configuration', NULL , @parent_menu_id, 2, '100', null, 1),
('Employee Claim List', @claim_employee_claim_list_screen_id , @parent_menu_id, 2, '200', null, 1),
('Assign Claim', @claim_assign_claim_screen_id , @parent_menu_id, 2, '300', null, 1),
('Submit Claim', @submit_claim_screen_id , @parent_menu_id, 2, '100', null, 1),
('My Claims List', @self_claims_list_screen_id , @parent_menu_id, 2, '200', null, 1);

set @parent_menu_id_level_2:= (SELECT id FROM ohrm_menu_item WHERE menu_title = 'Configuration' AND parent_id= @parent_menu_id);

INSERT INTO ohrm_menu_item (menu_title, screen_id, parent_id, level, order_hint, url_extras, status) VALUES
('Event', @claim_event_screen_id, @parent_menu_id_level_2, 3, '100', null, 1),
('Expense Types', @claim_expense_type_screen_id, @parent_menu_id_level_2, 3, '200', null, 1);

-- data group permissions
INSERT INTO ohrm_user_role_screen (user_role_id,screen_id, can_read) VALUES
(@admin_role_id, @claim_expense_type_screen_id, 1),
(@admin_role_id, @claim_event_screen_id, 1),
(@admin_role_id, @claim_employee_claim_list_screen_id, 1),
(@Supervisor_role_id, @claim_employee_claim_list_screen_id, 1),
(@admin_role_id, @claim_assign_claim_screen_id, 1),
(@Supervisor_role_id, @claim_assign_claim_screen_id, 1),
(@ESS_role_id, @submit_claim_screen_id, 1),
(@ESS_role_id, @self_claims_list_screen_id, 1);


INSERT INTO ohrm_data_group (name, description, can_read, can_create, can_update, can_delete) VALUES
  ('Claim - Expense Types', 'Claim Configuration of Expense Types', 1, 1, 1, 1),
  ('Claim - Event', 'Claim Configuration of Event', 1, 1, 1, 1),
  ('Claim - Employee Claim List','Employee Claim List', 1, 1, 1, 1),
  ('Claim - Assign Claim','Assign Claim', 1, 1, 1, 1),
  ('Claim - Submit Claim', 'Submit Claim Request', 1, 1, 1, 1),
  ('Claim - My Claims List','Self Claims List', 1, 1, 1, 1);


  SET @data_group_id := (SELECT id FROM ohrm_data_group WHERE name = 'Claim - Expense Types');
  SET @claim_event_data_group_id_ := (SELECT id FROM ohrm_data_group WHERE name = 'Claim - Event');
  SET @employee_claim_list_data_group_id_ := (SELECT id FROM ohrm_data_group WHERE name = 'Claim - Employee Claim List');
  SET @assign_claim_data_group_id_ := (SELECT id FROM ohrm_data_group WHERE name = 'Claim - Assign Claim');
  SET @submit_claim_data_group_id_ := (SELECT id FROM ohrm_data_group WHERE name = 'Claim - Submit Claim');
  SET @my_claims_list_data_group_id_ := (SELECT id FROM ohrm_data_group WHERE name = 'Claim - My Claims List');


INSERT INTO ohrm_data_group_screen (data_group_id, screen_id, permission) VALUES
  (@data_group_id, @claim_expense_type_screen_id, 1);
  (@claim_event_data_group_id_, @claim_event_screen_id, 1);
  (@employee_claim_list_data_group_id_, @claim_employee_claim_list_screen_id, 1);
  (@assign_claim_data_group_id_, @submit_claim_screen_id, 1),
  (@submit_claim_data_group_id_, @claim_assign_claim_screen_id, 1),
  (@my_claims_list_data_group_id_, @self_claims_list_screen_id, 1);



INSERT INTO ohrm_user_role_data_group (user_role_id, data_group_id, can_read, can_create, can_update, can_delete, self) VALUES
  (@admin_role_id, @data_group_id, 1, 1, 1, 1, 1),
  (@admin_role_id, @claim_event_data_group_id_, 1, 1, 1, 1, 1),
  (@admin_role_id, @assign_claim_data_group_id_, 1, 1, 1, 1, 1),
  (@admin_role_id, @employee_claim_list_data_group_id_, 1, 1, 1, 1, 1),
  (@Supervisor_role_id, @employee_claim_list_data_group_id_, 1, 1, 1, 1, 1),
  (@Supervisor_role_id, @assign_claim_data_group_id_, 1, 1, 1, 1, 1),
  (@ESS_role_id, @submit_claim_data_group_id_, 1, 1, 1, 1, 1),
  (@ESS_role_id, @my_claims_list_data_group_id_, 1, 1, 1, 1, 1);



CREATE TABLE ohrm_claim_event (
id INT AUTO_INCREMENT,
name TEXT,
description TEXT,
added_by INT,
is_deleted TINYINT DEFAULT '0' NOT NULL, PRIMARY KEY(id),
FOREIGN KEY(added_by) REFERENCES ohrm_user(id),)
ENGINE = INNODB;

CREATE TABLE ohrm_expense_type (
id INT AUTO_INCREMENT,
name TEXT,
description TEXT,
added_by INT,
status VARCHAR(64),
is_deleted TINYINT DEFAULT '0' NOT NULL, PRIMARY KEY(id),
FOREIGN KEY(added_by) REFERENCES ohrm_user(id))
ENGINE = INNODB;

CREATE TABLE ohrm_claim_request (
id INT AUTO_INCREMENT,
emp_number INT,
added_by INT,
event_type INT,
description TEXT,
currency TEXT,
is_deleted TINYINT DEFAULT '0' NOT NULL, PRIMARY KEY(id),
FOREIGN KEY(event_type) REFERENCES ohrm_claimEvent(id),
FOREIGN KEY(emp_number) REFERENCES hs_hr_employee(emp_number),
FOREIGN KEY(added_by) REFERENCES ohrm_user(id))
ENGINE = INNODB;

CREATE TABLE ohrm_expense (
id INT AUTO_INCREMENT,
expense_type_id INT,
date date,
amount TEXT,
note TEXT,
request_id INT,
is_deleted TINYINT DEFAULT '0' NOT NULL,
PRIMARY KEY(id),
FOREIGN KEY(request_id) REFERENCES ohrm_claim_request(id),
FOREIGN KEY(expense_type_id) REFERENCES ohrm_expense_type(id))
ENGINE = INNODB;

CREATE TABLE ohrm_claim_attachment (
request_id INT,
eattach_id BIGINT,
eattach_size INT DEFAULT '0',
eattach_desc VARCHAR(200),
eattach_filename VARCHAR(100),
eattach_attachment LONGBLOB,
eattach_type VARCHAR(200),
attached_by INT DEFAULT NULL,
attached_by_name VARCHAR(200),
attached_time DATETIME, PRIMARY KEY(request_id, eattach_id),
FOREIGN KEY (attached_by) REFERENCES hs_hr_employee(emp_number),
FOREIGN KEY(request_id) REFERENCES ohrm_claim_request(id))
ENGINE = INNODB;



