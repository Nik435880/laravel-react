import { useState, useRef, useEffect } from 'react';
import AppLayout from '@/layouts/app-layout';
import { useEchoPresence } from '@laravel/echo-react';
import { Room, Message, SharedData } from '@/types';
import { MessageList } from '@/components/message-list';
import { MessageForm } from '@/components/message-form';
import { usePage } from '@inertiajs/react';

export default function Show({ room }: { room: Room }) {
    const [messages, setMessages] = useState<Message[]>(room?.messages ?? []);
    const messageRef = useRef<HTMLUListElement | null>(null);


    const scrollToBottom = () => {
        if (messageRef.current) {
            console.log(messageRef.current.scrollTop)
            messageRef.current.scrollTop = messageRef.current.scrollHeight;
            console.log(messageRef.current.scrollHeight);
        }
    }

    const { auth } = usePage().props as unknown as SharedData;

    useEffect(() => {
        scrollToBottom();
    }, []);

    useEchoPresence(
        `room.${room?.id ?? ''}`,
        'MessageSent',
        (e: { message: Message }) => {
            setMessages((messages): Message[] => [...messages, e.message]);
            if (e.message.user.id === auth.user.id) {
                scrollToBottom();
            }
        }
    );

    return (
        <AppLayout>
            <MessageList messages={messages} messageRef={messageRef} />
            <MessageForm room={room} />
        </AppLayout>
    );
}
