import { MessageItem } from '@/components/message-item';
import { Message } from '@/types';
import React from 'react';

export const MessageList = ({
    messages,
    messageRef,
}: {
    messages: Message[];
    messageRef: React.RefObject<HTMLUListElement | null>;
}) => {
    return (
        <ul ref={messageRef} className="overflow-y-auto h-[calc(100vh-130px)]">
            {messages?.map((message: Message) => (
                <MessageItem message={message} key={message.id} />
            ))}
        </ul>
    );
};
