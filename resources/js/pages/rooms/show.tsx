import { useState, useRef } from 'react';
import { usePage } from '@inertiajs/react';
import AppLayout from '@/layouts/app-layout';
import { useEchoPresence } from '@laravel/echo-react';
import { Room, User, Message } from '@/types';
import { MessageList } from '@/components/message-list';
import { MessageForm } from '@/components/message-form';

export default function Show({ room }: { room: Room }) {
    const [messages, setMessages] = useState<Message[]>(room?.messages ?? []);
    const messageRef = useRef<HTMLUListElement | null>(null);
    const { user } = usePage().props.auth as { user: User };

    const handleScroll = () => {
        if (messageRef.current) {
            messageRef.current.scrollTop = messageRef.current.scrollHeight;
        }
    };

    useEchoPresence(
        `room.${room?.id ?? ''}`,
        'MessageSent',
        (e: { message: Message }) => {
            setMessages((messages): Message[] => [...messages, e.message]);
            handleScroll();
        }
    );

    return (
        <AppLayout>
            <MessageList messages={messages} messageRef={messageRef} />
            <MessageForm room={room} />
        </AppLayout>
    );
}
