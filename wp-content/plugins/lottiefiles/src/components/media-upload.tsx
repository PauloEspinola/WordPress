/**
 * Copyright 2022 Design Barn Inc.
 */

import { MediaUpload, MediaUploadCheck } from '@wordpress/block-editor';
import * as React from 'react';

import { IMyMediaUploaderProps } from '../interfaces';
import { isDotLottie, extractDotLottie } from '../utils';

const ALLOWED_MEDIA_TYPES = ['application/json', 'text/plain'];

export const MyMediaUploader: React.FC<IMyMediaUploaderProps> = ({
  gallery = false,
  onSelect,
  render,
}: IMyMediaUploaderProps) => {
  return (
    <MediaUploadCheck>
      <MediaUpload
        gallery={gallery}
        onSelect={(media): void => {
          if (['application/json', 'text/plain'].includes(media.mime) && media.url) {
            if (isDotLottie(media.url)) {
              const getLottie = async () => {
                try {
                  const jsonSrc = await extractDotLottie(media.url);

                  onSelect(jsonSrc);
                } catch (error) {
                  console.log(error);
                }
              };

              getLottie();

              return;
            }
            onSelect(media.url);
          }
        }}
        allowedTypes={ALLOWED_MEDIA_TYPES}
        render={render}
      />
    </MediaUploadCheck>
  );
};
