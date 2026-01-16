import { MessageImages } from '@/components/message-images';
import { UserInfo } from "@/components/user-info";
import { Message } from '@/types';

export function MessageItem({ message, currentUserId }: { message: Message; currentUserId: number }) {
    const isCurrentUser = message.user.id === currentUserId;

    return (
        <li className={`flex flex-col gap-2 p-2 md:p-3 rounded-lg w-full max-w-1/2  md:w-[600px] ${isCurrentUser
            ? 'bg-blue-600 self-start'
            : 'bg-gray-600 self-end'
            }`}>
            <UserInfo user={message.user} />
            <p className="break-words text-sm md:text-base">{message.text}</p>
            <MessageImages message={message} />
            <p className="text-gray-300 text-xs md:text-sm">
                {new Date(message.created_at).toLocaleString()}
            </p>

        </li>
    );
}
