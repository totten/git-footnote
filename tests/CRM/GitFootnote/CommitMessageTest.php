<?php
namespace CRM\GitFootnote;

class CommitMessageTest extends \PHPUnit_Framework_TestCase {
  function testEmpty() {
    $message = new CommitMessage("");
    $this->assertEquals("", $message->toString());
  }

  function testBasic() {
    $message = new CommitMessage("Hello\nworld");
    $this->assertEquals("Hello\nworld", $message->toString());
  }

  function testOneLink() {
    $message = new CommitMessage("Hello\nworld\n");
    $message->addLinkNote('http://example.com', 'Example');
    $this->assertEquals("Hello\nworld\n\n----------------------------------------\n * http://example.com (Example)\n", $message->toString());
  }

  function testMultipleLink() {
    $message = new CommitMessage("Hello\nworld\n");
    $message->addLinkNote('http://example.com', 'Example');
    $message->addLinkNote('http://example.org', 'Example For Good');
    $message->addLinkNote('http://example.com', 'Example Redundant');
    $this->assertEquals("Hello\nworld\n\n----------------------------------------\n * http://example.com (Example)\n * http://example.org (Example For Good)\n", $message->toString());
  }
}
