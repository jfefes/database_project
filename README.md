database_project
================

Built for CSIT455- Object/Relational Databases class at State University of New York at Fredonia.

Project allows creation of airports, flights assigned to those airports, and customers/employees assigned to certain flights. Flights can be set as "in-flight", which restricts changes in other resources.

Using PHP 5.4, project utilizes the Oracle Call Interface (OCI) to connect to an off-site Oracle server. 
Development server hosted locally on a Zend Community Server- Apache with built-in OCI libraries. The academic purpose of this project was to demonstrate a working knowledge of raw SQL, therefore the project takes an MVC-like approach to resources without implementation of an MVC framework. 

To get working:
Update main directory in includes/site.inc. Currently assumes that the main directory of the project from the server root is /trunk/, modify as needed.
