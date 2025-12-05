import React, { useState, useEffect } from "react"
import AppLayout from '@/layouts/app-layout';
import { ListItem } from '@/components/ui/list-item';
import { FileImage } from 'lucide-react';
import { SendHorizontal } from 'lucide-react';
import { useEchoPresence } from "@laravel/echo-react";
import { Form } from '@inertiajs/react';
import { Room, Messages } from '@/types';
import { Button } from '@/components/ui/button';
import { Label } from '@/components/ui/label';
import { Input } from '@/components/ui/input';

export default function Show({
    room
}: {
    room: Room
}) {

    const [messages, setMessages] = useState<Messages[]>(room.messages);
    const messageRef = React.useRef<HTMLUListElement>(null);

    const handleScroll = () => {
        if (messageRef.current) {
            messageRef.current.scrollTop = messageRef.current.scrollHeight;
        }
    };

    useEffect(() => {
        handleScroll();
    }, []);


    useEchoPresence(`room.${room.id}`, 'MessageSent', (e: { id: number, message: { text: string, id: number, created_at: string, user: { name: string, avatar: { avatar_path: string } }, images: { image_path: string, id: number }[] } }) => {
        if (e.message.id > messages[messages.length - 1]?.id) {
            setMessages((messages): Messages[] => [...messages, e.message]);
        }
    });

    return (
        <AppLayout>
            <div>
                <div>
                    <ul className="overflow-y-auto h-[calc(100svh-117px)] "
                        ref={messageRef}>
                        {messages.map((message: {
                            text: string;
                            id: number;
                            created_at: string;
                            user: { name: string; avatar: { avatar_path: string } };
                            images: { image_path: string; id: number }[];
                        }) => (
                            <ListItem message={message} key={message.id} />
                        ))}
                    </ul>


                </div>
                <Form method='POST' className='flex items-center gap-1 p-2 border-t' action={`/rooms/${room.id}`} encType="multipart/form-data" resetOnSuccess>

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
                    <Button type='submit' className='rounded-full '>
                        <SendHorizontal className="size-full" />
                    </Button>

                </Form>
            </div>
        </AppLayout>

    )

}


