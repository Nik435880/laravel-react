
import { Image } from '@/types';

export function MessageImage({ image, className, id }: { image: Image, className?: string, id?: string }) {
    return (
        <img
            className={className}
            src={`/storage/${image.image_path}`}
            alt={`Thumbnail ${image.id}`}
            id={id}
        />
    );
}
