import React from 'react';
import { MessageItem } from '@/components/message-item';
import { Message } from '@/types';


export const MessageList = ({
    messages,
    messageRef,
}: {
    messages: Message[];
    messageRef: React.RefObject<HTMLUListElement | null>;
}) => {

    return (
        <ul ref={messageRef} className="flex flex-col w-full items-start overflow-y-auto overflow-x-hidden gap-2 p-2 transition-[width,height] ease-linear">
            {messages?.map((message: Message) => (
                <MessageItem key={message.id} message={message} />
            ))}
        </ul>
    );
};
