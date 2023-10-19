/**
 * Copyright 2022 Design Barn Inc.
 */

import { TrackerProvider } from '@context/tracker-provider';
import { AlignmentToolbar, BlockControls, InspectorControls, useBlockProps } from '@wordpress/block-editor';
import { ToolbarGroup } from '@wordpress/components';
import { useState } from '@wordpress/element';
import * as React from 'react';
import { MemoryRouter as Router } from 'react-router-dom';

import { BigModal } from '../../components';
import { ErrorBoundary } from '../../components/ErrorBoundary';
import { LottieProvider } from '../../context/lottie-provider';
import '../global.css';
import { IAppProps, ILottieBlockControlsProps } from '../../interfaces';
// import { ReactQueryProvider } from '../../react-query';
import { Header } from '../Layout/Header';
import { Navbar } from '../Layout/Header/Components';

import { AppRoute } from './app-route';
import { Placeholder, ReplaceMenu } from './block-editor';
import { AdvanceSettings, AnimationSettings, BackgroundSettings } from './block-settings-controls';

export interface AppState {
  name: string;
}

export const LottieBlockControls: React.FC<ILottieBlockControlsProps> = ({
  attributes,
  setAttributes,
}: ILottieBlockControlsProps) => {
  return (
    <>
      <BlockControls key="block Controls">
        <ToolbarGroup>
          <AlignmentToolbar
            value={attributes.contentAlign}
            onChange={(value: string): void =>
              setAttributes({
                contentAlign: value === 'undefined' ? attributes.contentAlign : value,
              })
            }
          />
        </ToolbarGroup>
        <ReplaceMenu attributes={attributes} setAttributes={setAttributes} />
      </BlockControls>

      <InspectorControls>
        <AnimationSettings attributes={attributes} setAttributes={setAttributes} />
        <BackgroundSettings attributes={attributes} setAttributes={setAttributes} />
        <AdvanceSettings attributes={attributes} setAttributes={setAttributes} />
      </InspectorControls>
    </>
  );
};

export const edit: React.FC<IAppProps> = ({ hostApp, tracker }: IAppProps) => {
  const [isOpen, setOpen] = useState(false);
  const openModal = () => setOpen(true);
  const closeModal = () => setOpen(false);

  // eslint-disable-next-line @typescript-eslint/unbound-method
  const { attributes, setAttributes } = hostApp;

  return (
    <ErrorBoundary>
      {/* <ReactQueryProvider> */}
      <Router>
        <TrackerProvider instance={tracker}>
          <LottieProvider
            isOpen={isOpen}
            closeModal={closeModal}
            openModal={openModal}
            attributes={attributes}
            setAttributes={setAttributes}
          >
            <LottieBlockControls attributes={attributes} setAttributes={setAttributes} />
            {isOpen && (
              <BigModal isOpen={isOpen} toggleModal={(): void => closeModal()}>
                <Header>
                  <Navbar toggleModal={closeModal} />
                </Header>

                <AppRoute attributes={attributes} setAttributes={setAttributes} />
              </BigModal>
            )}
            <div {...useBlockProps()}>
              <Placeholder attributes={attributes} setAttributes={setAttributes} />
            </div>
          </LottieProvider>
        </TrackerProvider>
      </Router>
      {/* </ReactQueryProvider> */}
    </ErrorBoundary>
  );
};
