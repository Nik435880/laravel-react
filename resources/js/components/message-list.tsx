import React from 'react';
import { MessageItem } from '@/components/message-item';
import { Message } from '@/types';
import { usePage } from "@inertiajs/react"
import { SharedData } from "@/types";

export const MessageList = ({
    messages,
    messageRef,
}: {
    messages: Message[];
    messageRef: React.RefObject<HTMLUListElement | null>;
}) => {
    const { auth } = usePage().props as unknown as SharedData;

    return (
        <ul ref={messageRef} className="overflow-y-auto overflow-x-hidden flex h-full flex-1 flex-col gap-2 md:gap-4 px-2 md:px-4 py-3 md:py-4">
            {messages?.map((message: Message) => (
                <MessageItem key={message.id} message={message} currentUserId={auth.user.id} />
            ))}
        </ul>
    );
};


