<?php
namespace CRM\GitFootnote;

class JiraFilter extends AbstractWordFilter {

  protected $wordPattern;
  protected $url;
  protected $toTitle;

  /**
   * @param string $wordPattern
   * @param string $url
   * @param callable|NULL $toTitle
   */
  public function __construct($wordPattern, $url, $toTitle = NULL) {
    $this->wordPattern = $wordPattern;
    $this->url = $url;
    $this->toTitle = $toTitle;
  }

  public function filterWord(CommitMessage $message, $word) {
    if (preg_match($this->wordPattern, $word)) {
      if ($this->toTitle) {
        $title = call_user_func($this->toTitle, $word);
      } else {
        $title = NULL;
      }
      $message->addLinkNote($this->url . '/' . $word, $title);
    }
    return $word;
  }
}
