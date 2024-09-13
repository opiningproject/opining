<?php
    $previousKey = null;
?>
<?php $__currentLoopData = $messages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $msg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <p class="message-date text-center">
        <span class="date_hidden {date_new_{$key}}" style="display: none"> <?php echo e($key); ?> </span>
        <?php if($previousKey != $key): ?>
            <span class="d-inline-block date_show" id="date_show"> <?php echo e($key); ?> </span>
            <span class="page_count" style="display: none"> <?php echo e($pageCount); ?> </span>
        <?php endif; ?>
    </p>
    <?php $previousKey = $key ?>
    <?php $__currentLoopData = $msg; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $message): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php if($message->receiver_id): ?>
            <?php
                $image = asset('images/user-profile-img-up.svg');
                if ($message->sender->id != 1 && $message->receiver->id) {
                    $image = $message->sender->image ? $message->sender->image : $message->receiver->image;
                }
            ?>
        <?php endif; ?>
        <div class="chat-item d-flex align-items-end justify-content-start gap-3" style="<?php echo e($message->appendStyle); ?>">
            <img src="<?php echo e($image); ?>" alt="Profile-Img" class="img-fluid" width="56" height="56">
            <div class="chat-item-textgrp d-flex flex-column gap-2 gap-sm-3">
                <?php if($message->message!= null): ?>
                    <p class="<?php echo e($message->messageClass); ?>" style=<?php echo e($message->messageStyle); ?>><?php echo e($message->message); ?></p>
                <?php endif; ?>
                <?php if($message->attachment): ?>
                    <a href="<?php echo e($message->attachment); ?>" target="_blank">
                        <img src="<?php echo e($message->attachment); ?>" style="height: 100px;width: 100px;">
                    </a>
                <?php endif; ?>
                <small
                    style="text-align: <?php echo e($message->messageClass == "rightChat" ? 'right' : 'left'); ?>;"><?php echo e(date('h:i A', strtotime($message->created_at))); ?></small>
            </div>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>



<?php /**PATH E:\wamp\www\go-meal\resources\views/admin/chats/messages.blade.php ENDPATH**/ ?>