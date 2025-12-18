import { Message } from '@/types';
import { MessageImages } from '@/components/message-images';
import { MessageUser } from '@/components/message-user';


export function MessageItem({ message }: { message: Message }) {
    return (
        <li className="border-b last:border-b-0">
            <div className="p-4">
                <MessageUser message={message} />

                <p className="whitespace-pre-wrap break-words ">{message.text}</p>

                <MessageImages message={message} />

                <p className="text-gray-500 text-sm ">
                    {new Date(message.created_at).toLocaleString()}
                </p>
            </div>
        </li>
    );
}
