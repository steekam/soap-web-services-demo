<?php
require_once '../vendor/autoload.php';
require_once '../constants.php';

use App\Models\Student;


$server = new nusoap_server();

$server->configureWSDL("Student Manager", "urn:student_manager"); // Configure WSDL file


// Register Complex Types
$server->wsdl->addComplexType(
    'student',
    'complexType',
    'struct',
    'all',
    '',
    [
        "id" => ["name" => "id", "type" => "xsd:string"],
        "name" => ["name" => "name", "type" => "xsd:string"],
        "email" => ["name" => "email", "type" => "xsd:string"],
        "phone_number" => ["name" => "phone_number", "type" => "xsd:string"],
        "address" => ["name" => "address", "type" => "xsd:string"],
        "entry_points" => ["name" => "entry_points", "type" => "xsd:string"],
    ],
    [], // attributes
);


// Register service methods
function get_student_by_admission(string $admission_number)
{
    $student = (new Student())->get_by_admission($admission_number);
    if(!$student) {
        return new soap_fault("SOAP-ENV:Client", "", "Could not find student record");
    }
    return $student;
}
$server->register(
    "get_student_by_admission",
    ["admission_number" => "xsd:string"],
    ["return" => "tns:student"]
);


// Handle requests
$server->service(file_get_contents("php://input"));
