<?php
namespace App\Controller;

class QuestionsController extends AppController
{
  public function initialize()
  {
    parent::initialize();
    $this->loadComponent('RequestHandler');
  }

  public function random()
  {
    $questions = $this->Questions->find('all');
    $count = $questions->count();
    $index = rand(0, $count - 1);
    $i = 0;
    $response = null;
    foreach ($questions as $question)
    {
      if ($i == $index)
      {
        $response = $question;
        $this->set([
            'question' => json_encode($question),
            'autoRender' => false,
            '_serialize' => ['question']
        ]);
        break;
      }
      ++$i;
    }
  }

  public function submit()
  {
    if ($this->request->is('post'))
    {
      $request = $this->request->getData();
      $submitedQuestionId = $request['id'];
      $submitedAnswer = $request['answer'];
      $question = $this->Questions->get($submitedQuestionId);
      $response = isAnswerCorrect($question, $submitedAnswer);
      $this->set([
          'response' => json_encode($response),
          '_serialize' => ['response']
      ]);
    }
  }
}

function isAnswerCorrect($question, $submitedAnswer)
{
  $response = [];
  if (!$question)
  {
    $response['status'] = -1;
    $response['message'] = 'Error: incorrect question id.';
  }
  else
  {
    if (strcmp($question['correct_answer'], $submitedAnswer) == 0)
    {
      $response['status'] = 1;
      $response['message'] = 'Correct.';
    }
    else
    {
      $response['status'] = 0;
      $response['message'] = 'Incorrect.';
    }
  }
  return $response;
}
?>
