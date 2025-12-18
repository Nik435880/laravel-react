import { ListItem } from '@/components/ui/list-item';
import { Room, Messages } from '@/types';
import React from 'react';


export const MessageList = ({ messages, messageRef }: { messages: Messages[]; messageRef: React.RefObject<HTMLUListElement | null> }) => {
    return (
        <ul className="overflow-y-auto scrollbar h-[calc(100vh-130px)] flex flex-col"
            ref={messageRef}>
            {messages?.map((message: {
                text: string;
                id: number;
                created_at: string;
                user: { name: string; avatar: { avatar_path: string } };
                images: { image_path: string; id: number }[];
            }) => (
                <ListItem message={message} key={message.id} />
            ))}
        </ul>
    );
}

