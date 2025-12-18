import { useState, useRef } from 'react';
import AppLayout from '@/layouts/app-layout';
import { useEchoPresence } from '@laravel/echo-react';
import { Room, Message } from '@/types';
import { MessageList } from '@/components/message-list';
import { MessageForm } from '@/components/message-form';

export default function Show({ room }: { room: Room }) {
    const [messages, setMessages] = useState<Message[]>(room?.messages ?? []);
    const messageRef = useRef<HTMLUListElement | null>(null);

    useEchoPresence(
        `room.${room?.id ?? ''}`,
        'MessageSent',
        (e: { message: Message }) => {
            setMessages((messages): Message[] => [...messages, e.message]);

        }
    );

    return (
        <AppLayout>
            <MessageList messages={messages} messageRef={messageRef} />
            <MessageForm room={room} />
        </AppLayout>
    );
}
