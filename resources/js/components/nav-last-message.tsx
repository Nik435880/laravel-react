import { UserInfo } from '@/components/user-info';
import { Message, User } from '@/types';
import { Image } from 'lucide-react';

export function NavLastMessage({
    message,
    user,
}: {
    message: Message;
    user: User;
}) {
    return (
        <div className="w-full flex flex-col">
            <UserInfo user={user} />
            <span className="mt-1 text-sm">{message.user.name}:</span>

            <div className="flex flex-row gap-1 justify-between ">
                {message.text && (
                    <p className="truncate text-sm">{message.text}</p>
                )}
                {message.images.length > 0 && (
                    <span className=" text-sm flex flex-row gap-1">
                        {message.images.length} <Image size={16} />
                    </span>
                )}
            </div>

            <span className="text-gray-500 text-sm">
                {new Date(message.created_at).toLocaleString()}
            </span>
        </div>
    );
}
