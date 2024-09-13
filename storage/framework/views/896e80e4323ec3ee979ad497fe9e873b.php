<div class="chat-user-list">
    <?php $__currentLoopData = $chats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $chat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php if($chat != null): ?>
            <?php if($chat->id !== auth()->id()): ?>
                <div class="ChatDiv-type">
                    <div class="ChatDiv-list" data-id="<?php echo e(getAdminUser()->id); ?>" data-receiver-id="<?php echo e($chat->id); ?>"
                         data-chat-id="<?php echo e($chat->chats->id); ?>" data-status="<?php echo e($chat->is_online); ?>"
                         data-user="<?php echo e($chat->id); ?>">
                        <input type="hidden" name="socketId" class="socketId" value="<?php echo e($chat->socket_id); ?>"
                               id="socketId">
                        <input type="hidden" name="sender_id" class="sender_id" value="<?php echo e(getAdminUser()->id); ?>"
                               id="sender_id_1">
                        <input type="hidden" name="receiver_id" class="receiver_id"
                               value="<?php echo e($chat->chats->sender_id); ?>"
                               id="receiver_id_<?php echo e($chat->chats->sender_id); ?>">
                        <div class="ChatDiv-item d-flex align-items-center justify-content-start gap-2"
                             id="chat_item_<?php echo e($chat->chats->id); ?>">
                            <img src="<?php echo e($chat->image ? $chat->image : asset('images/user-profile-img-up.svg')); ?>"
                                 alt="Profile-Img" class="img-fluid userimage" width="56" height="56">
                            <div class="text-grp d-flex flex-column sender_name">
                                <div class="title"
                                     <?php if($chat->unreadCount && $chat->unreadCount > 0): ?> style="font-weight:bold" <?php endif; ?>>
                                    <?php echo e(ucfirst($chat->full_name)); ?>


                                </div>
                                <div class="text"><?php echo e($chat->chats->created_at->format('h:i a | d, M Y')); ?></div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>
<?php /**PATH E:\wamp\www\go-meal\resources\views/admin/chats/chat-list.blade.php ENDPATH**/ ?>