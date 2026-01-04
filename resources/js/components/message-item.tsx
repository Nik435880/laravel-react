import { Message } from '@/types';
import { MessageImages } from '@/components/message-images';
import { UserInfo } from "@/components/user-info";

export function MessageItem({ message }: { message: Message }) {
    return (
        <li className="p-2">
            <UserInfo user={message.user} />
            <p className="break-words">{message.text}</p>
            <MessageImages message={message} />
            <p className="text-gray-500 text-sm">
                {new Date(message.created_at).toLocaleString()}
            </p>

        </li>
    );
}
