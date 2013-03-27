<?php
namespace CRM\GitFootnote;

class JiraFilterTest extends \PHPUnit_Framework_TestCase {
  function offlineCases() {
    // each test case is three parts: inputMessageBody, expectedMessageBody, expectedFootnotes
    $cases = array();
    $cases[] = array(
      "",
      "",
      array()
    );
    $cases[] = array(
      "Hello",
      "Hello",
      array()
    );
    $cases[] = array(
      "CRM-1234",
      "CRM-1234",
      array('http://example.com/jira/CRM-1234')
    );
    $cases[] = array(
      "Hello CRM-1234",
      "Hello CRM-1234",
      array('http://example.com/jira/CRM-1234')
    );
    $cases[] = array(
      " Hello CRM-1234",
      " Hello CRM-1234",
      array('http://example.com/jira/CRM-1234')
    );
    $cases[] = array(
      "Hello CRM-1234! ",
      "Hello CRM-1234! ",
      array('http://example.com/jira/CRM-1234')
    );
    $cases[] = array(
      "CRM-1234 Hello",
      "CRM-1234 Hello",
      array('http://example.com/jira/CRM-1234')
    );
    $cases[] = array(
      "CRM-1234 CRM-567",
      "CRM-1234 CRM-567",
      array('http://example.com/jira/CRM-1234', 'http://example.com/jira/CRM-567')
    );
    $cases[] = array(
      "Hello\nCRM-1234",
      "Hello\nCRM-1234",
      array('http://example.com/jira/CRM-1234')
    );
    $cases[] = array(
      "CRM-1234\nHello",
      "CRM-1234\nHello",
      array('http://example.com/jira/CRM-1234')
    );
    $cases[] = array(
      "CRM-1234\nCRM-567",
      "CRM-1234\nCRM-567",
      array('http://example.com/jira/CRM-1234', 'http://example.com/jira/CRM-567')
    );
    $cases[] = array(
      "Hello, CRM-1234... is... like CRM-567!",
      "Hello, CRM-1234... is... like CRM-567!",
      array('http://example.com/jira/CRM-1234', 'http://example.com/jira/CRM-567')
    );
    $cases[] = array(
      "ACRM-1234 Hello",
      "ACRM-1234 Hello",
      array()
    );
    return $cases;
  }

  /**
   * @dataProvider offlineCases
   * @param string $messageBody
   * @param array $expectedNotes footnotes that should be produced
   */
  function testOfflineCases($messageBody, $expectedBody, $expectedNotes) {
    $message = new CommitMessage($messageBody);
    $filter = new JiraFilter('/^CRM-[0-9]+/', 'http://example.com/jira');
    $filter->filter($message);
    $this->assertEquals($expectedBody, $message->getMessage());
    $this->assertEquals($expectedNotes, array_values($message->getNotes()));
  }
}
