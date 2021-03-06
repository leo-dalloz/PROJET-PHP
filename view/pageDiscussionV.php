<?php
require '../utils.inc.php';
$i_numDiscussion = $_GET['discussionId'];
$tab_discussions = getDiscussions();
$title = 'Discussion ' .$D_discussion->getName().' | Freenote';
$style = '../assets/css/discussion.css';
$style_theme = '../assets/css/theme/day.css';
ob_start();
?>
    <main>
        <section id="ListConversationContainer">
            <p id="ListConversation">
                Conversations
            </p>
            <div id="LConvContainer">
                <?php foreach ($tab_discussions as $value) { ?>
                    <button class="buttonLConv" onclick="window.location.href='../controller/pageDiscussionC.php?discussionId=<?= $value->getDiscussionId()?>'">
                        <ul class="LConv">
                            <div class="FirstLine">
                                <li>
                                    <a href="../controller/pageDiscussionC.php?discussionId=<?= $value->getDiscussionId()?>" class="LinkDiscu"><?= $value->getName()?></a>
                                </li>
                                <li>
                                    <?= $value->getNbMessages() ?> Messages
                                </li>
                            </div>
                            <div class="SecondLine">
                                <li>
                                    <?php $b_isOuvert = $value->getState()?>
                                    <p class="<?= ($b_isOuvert) ? 'Open' : 'Close' ?>"><?= ($b_isOuvert) ? 'Ouverte' : 'Fermée' ?></p>
                                </li>
                                <li >
                                    <?= $value->getNbLike() ?> <i class="fas fa-thumbs-up"></i>
                                </li>
                            </div>
                        </ul>
                    </button>
                <?php }?>
            </div>
        </section>

        <section id="conversationContainer">
            <div id="headConversationContainer">
                <p id="titleConversation">
                    <?= $D_discussion->getName(); ?>
                </p>
                <p id="likeContainer">
                    <?= $D_discussion->getNbLike(); ?>
                    like(s)
                <form action="../controller/pageDiscussionC.php?discussionId=<?=$i_discussionId?>" method="post">
                    <button class="likeButton" type="submit" name="action" value="like">
                        Like <i class="fas fa-heart"></i>
                    </button>
                </form>
                </p>
            </div>
            <div id="LMessageContainer">
                <?php $Messages = $D_discussion->getMessages();
                foreach ($Messages as $message) {
                    ?>
                    <div id="listMessage">
                        <div class="line">
                            <p class="message">
                                <?= $message->show(); ?>
                            </p>
                        </div>
                    </div>
                    <?php
                }
                ?>
            </div>
            <div id="SendMessageContainer">
                <form id="formMessage" action="../controller/pageDiscussionC.php?discussionId=<?=$i_discussionId?>" method="post" >
                    <input id="contentInput" type="text" name="contents" placeholder="Message">
                    <button id="submitButton" type="submit" name="action" value="sendMessage"><i class="fab fa-telegram-plane"></i></button>
                </form>
            </div>
        </section>
    </main>
<?php
$content = ob_get_clean();
require('../template.php');
?>