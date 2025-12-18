import { MessageItem } from '@/components/message-item';
import { Message } from '@/types';
import React from 'react';


export const MessageList = ({ messages, messageRef }: { messages: Message[]; messageRef: React.RefObject<HTMLUListElement | null> }) => {
    return (
        <ul className="overflow-y-auto scrollbar h-[calc(100vh-130px)] flex flex-col"
            ref={messageRef}>
            {messages?.map((message: Message) => (
                <MessageItem message={message} key={message.id} />
            ))}
        </ul>
    );
}
