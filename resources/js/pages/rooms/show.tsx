import { useState, useEffect, useRef } from "react"
import AppLayout from '@/layouts/app-layout';
import { FileImage } from 'lucide-react';
import { SendHorizontal } from 'lucide-react';
import { useEchoPresence } from "@laravel/echo-react";
import { Form } from '@inertiajs/react';
import { Room, Messages } from '@/types';
import { Button } from '@/components/ui/button';
import { Label } from '@/components/ui/label';
import { Input } from '@/components/ui/input';
import { MessageList } from '@/components/ui/message-list';




export default function Show({
    room
}: {
    room: Room
}) {

    const [messages, setMessages] = useState<Messages[]>(room?.messages ?? []);
    const messageRef = useRef<HTMLUListElement | null>(null);

    const handleScroll = () => {
        if (messageRef.current) {
            messageRef.current.scrollTop = messageRef.current.scrollHeight;
        }
    };

    useEffect(() => {
        handleScroll();
    }, [])


    useEchoPresence(`room.${room?.id ?? ''}`, 'MessageSent', (e: { message: Messages }) => {
        if (e.message.id > messages[messages.length - 1]?.id) {
            setMessages((messages): Messages[] => [...messages, e.message]);

        }
    });

    return (
        <AppLayout>
            <div>
                <MessageList messages={messages} messageRef={messageRef} />

                <Form method='POST' className='flex items-center justify-between gap-1 p-2 border-t dark:border-sidebar-border h-16' action={room?.id ? `/rooms/${room.id}` : '#'} encType="multipart/form-data" resetOnSuccess >

                    <Input type="text" name='text' id='text' placeholder='Enter message...' autoComplete='off'
                    />
                    <Label htmlFor="images" className='flex items-center justify-center '>
                        <FileImage size={32} />
                    </Label>
                    <Input
                        id="images"
                        name="images[]"
                        type="file"
                        className="hidden"
                        multiple // Allow multiple file selection

                    />
                    <Button type='submit' className='rounded-full size-9' disabled={!room?.id}>
                        <SendHorizontal size={32} />
                    </Button>

                </Form>
            </div>
        </AppLayout>

    )

}


