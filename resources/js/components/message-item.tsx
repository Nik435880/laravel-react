import { MessageImages } from '@/components/message-images';
import { UserInfo } from "@/components/user-info";
import { Message, SharedData } from '@/types';
import { usePage } from "@inertiajs/react";

export function MessageItem({ message }: { message: Message }) {

    const { auth } = usePage().props as unknown as SharedData;

    return (
        <li className="flex flex-col rounded-md p-2 text-wrap text-clip shadow-md w-full">
            <UserInfo user={message.user} />
            <p className="break-all whitespace-normal">{message.text}</p>
            <MessageImages message={message} />
            <p className="text-gray-500 text-sm">
                {new Date(message.created_at).toLocaleString()}
            </p>

        </li>
    );
}
